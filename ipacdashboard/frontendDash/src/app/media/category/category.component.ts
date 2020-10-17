/**
 * @author victor
 * category management
 */
import { Component, OnInit, ViewChild, Inject } from '@angular/core';
import { CategoryService } from "../../services/category.service";
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { FormControl, FormGroupDirective, NgForm, Validators } from '@angular/forms';
import { ErrorStateMatcher } from '@angular/material/core';
import { MatSnackBar } from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}

export interface Category {
  cat_description: string;
  category: string;
  id: string;
}

export interface CategoryResponse {
  counter: number;
  msg: string;
  num_pages: number;
  result: Category[];
  status: boolean;
  total_records: number;
}

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})
export class CategoryComponent implements OnInit {
  catSwitch = 'loading';
  displayedColumns = ['category', 'cat_description', 'edit_cat', 'delete_cat'];
  dataSource = new MatTableDataSource<any>([]);

  private paginator: MatPaginator;
  private sort: MatSort;

  @ViewChild('paginator') set matPaginator1(mp: MatPaginator) {
    this.paginator = mp;
    this.setDataSourceAttributesYear();
  }

  @ViewChild(MatSort) set matSort(ms: MatSort) {
    this.sort = ms;
    this.setDataSourceAttributesYearSort();
  }

  setDataSourceAttributesYear() {
    this.dataSource.paginator = this.paginator;
  }

  setDataSourceAttributesYearSort() {
    this.dataSource.sort = this.sort;
  }

  constructor(
    private _cat: CategoryService,
    public dialog: MatDialog,
    public snackBar: MatSnackBar,
    private store: Store<fromStore.State>
  ) { }

  ngOnInit() {
    this.fetchCat();
  }

  fetchCat() {
    this._cat.fetchAllCategories().subscribe((response: CategoryResponse) => {
      const data = response;
      if (!data.result) {
        this.catSwitch = 'nodata';
      } else {
        this.catSwitch = 'active';
        this.dataSource = new MatTableDataSource(data.result);
      }
    });
  }

  addCategory() {
    const dialogRef = this.dialog.open(DialogAddCatComponent, {
      width: '80%',
      height: '80%'
    });

    dialogRef.afterClosed().subscribe(result => {
      if (!result) {
        return;
      } else {
        if (result.status) {
          this.snackBar.open(result.message, 'Close', {
            duration: 2000,
          });
          this.fetchCat();
        } else {
          this.snackBar.open('Error while adding category!', 'Close', {
            duration: 2000,
          });
        }
      }
    });
  }

  editCategory(row) {
    const dialogRef = this.dialog.open(DialogEditCatComponent, {
      width: '80%',
      height: '80%',
      data: row
    });

    dialogRef.afterClosed().subscribe(result => {
      if (!result) {
        return;
      } else {
        if (result.status) {
          this.snackBar.open(result.message, 'Close', {
            duration: 2000,
          });
          this.fetchCat();
        } else {
          this.snackBar.open('Error while editing category!', 'Close', {
            duration: 2000,
          });
        }
      }
    });
  }

  deleteCat(row) {
    this.catSwitch = 'delete';
    this._cat.deleteCat(row.id).subscribe((response) => {
      if (!response) {
        this.snackBar.open('Error while deleting category!', 'Close', {
          duration: 2000,
        });
        this.catSwitch = 'active';
      } else {
        if (response.status) {
          this.snackBar.open(response.message, 'Close', {
            duration: 2000,
          });
        } else {
          this.snackBar.open('Error while deleting category!', 'Close', {
            duration: 2000,
          });
        }
        this.fetchCat();
        this.catSwitch = 'active';
      }
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

}

@Component({
  selector: 'app-dialog-add-cat',
  templateUrl: 'dialog-add-cat.html',
  styleUrls: ['./category.component.css']
})
export class DialogAddCatComponent {

  message = false;

  constructor(
    public dialogRef: MatDialogRef<DialogAddCatComponent>,
    private _cat: CategoryService
  ) {
  }

  catFormControl = new FormControl('', [
    Validators.required
  ]);

  catDescFormControl = new FormControl('', [
    Validators.required
  ]);

  addCat() {
    const payload = <{ category: string, description: string }>{};
    payload.category = this.catFormControl.value;
    payload.description = this.catDescFormControl.value;
    this.message = true;
    this._cat.addCat(payload).subscribe((response) => {
      this.message = false;
      this.dialogRef.close(response);
    });
  }

  matcher = new MyErrorStateMatcher();

}

@Component({
  selector: 'app-dialog-edit-cat',
  templateUrl: 'dialog-edit-cat.html',
  styleUrls: ['./category.component.css']
})
export class DialogEditCatComponent {

  message = false;

  constructor(
    public dialogRef: MatDialogRef<DialogEditCatComponent>,
    private _cat: CategoryService,
    @Inject(MAT_DIALOG_DATA) public data
  ) {
    this.catFormControl.patchValue(data.category);
    this.catDescFormControl.patchValue(data.cat_description);
  }

  catFormControl = new FormControl('', [
    Validators.required
  ]);

  catDescFormControl = new FormControl('', [
    Validators.required
  ]);

  editCat() {
    const payload = <{ category: string, description: string, id: string }>{};
    payload.category = this.catFormControl.value;
    payload.description = this.catDescFormControl.value;
    payload.id = this.data.id;
    this.message = true;
    this._cat.editCat(payload).subscribe((response) => {
      this.message = false;
      this.dialogRef.close(response);
    });
  }
  matcher = new MyErrorStateMatcher();

}

