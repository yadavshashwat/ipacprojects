/**
 * @author victor
 * User management component
 */
import {
  Component,
  OnInit,
  ViewChild
} from '@angular/core';
import {
  MatDialog,
  MatDialogRef
} from '@angular/material';
import {
  FormGroup,
  FormBuilder,
  Validators
} from '@angular/forms';
import { UsersService } from '../../services/users.service';
import { MatSnackBar } from '@angular/material';
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';

@Component({
  selector: 'app-user-manage',
  templateUrl: './user-manage.component.html',
  styleUrls: ['./user-manage.component.css']
})
export class UserManageComponent implements OnInit {

  userSwitch = 'loading';
  displayedColumns = ['name', 'email', 'ipac_admin', 'media_admin', 'digital_admin', 'delete'];
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
    public dialog: MatDialog,
    private _snack: MatSnackBar,
    private _user: UsersService
  ) {

  }

  ngOnInit() {
    this.fetchUsers();
  }

  fetchUsers() {
    this.userSwitch = 'loading';
    this._user.getAll().subscribe((data) => {
      if (!data) {
        this._snack.open('Error while fetching staff', 'Close', {
          duration: 1000
        });
        this.userSwitch = 'nodata';
        return;
      }
      if (!data.hasOwnProperty('result')) {
        this._snack.open('Error while fetching staff', 'Close', {
          duration: 1000
        });
        this.userSwitch = 'nodata';
      }
      this.dataSource = new MatTableDataSource<any>(data.result);
      this.userSwitch = 'active';
    });
  }

  createUser() {
    const dialogRef = this.dialog.open(DialogUserComponent, {
      width: '80%',
      height: '80%'
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this._snack.open('Success!', 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
      }
    });
  }

  updateAccessAdmin(event, el) {
    el.is_admin = event.checked;
    el.is_media_admin = event.checked;
    el.is_digital_admin = event.checked;
    this._user.updateAccess(el).subscribe((data: any) => {
      if (!data) {
        this._snack.open('Error while updating access', 'Close', {
          duration: 1000
        });
        this.fetchUsers();
        return;
      }
      if (data.status) {
        this._snack.open(data.Message, 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
      }
    });
  }

  updateAccessMedia(event, el) {
    el.is_media_admin = event.checked;
    this._user.updateAccess(el).subscribe((data: any) => {
      if (!data) {
        this._snack.open('Error while updating access', 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
        return;
      }
      if (data.status) {
        this._snack.open(data.Message, 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
      }
    });
  }

  updateAccessDigital(event, el) {
    el.is_digital_admin = event.checked;
    this._user.updateAccess(el).subscribe((data: any) => {
      if (!data) {
        this._snack.open('Error while updating access', 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
        return;
      }
      if (data.status) {
        this._snack.open(data.Message, 'Close', {
          duration: 1000
        });
        // this.fetchUsers();
      }
    });
  }

  deleteUser(element) {
    this.userSwitch = 'delete';
    this._user.deleteUser(element.id).subscribe((data) => {
      this.fetchUsers();
      this.userSwitch = 'active';
    });
  }

}

@Component({
  selector: 'app-dialog-add-user',
  templateUrl: 'dialog-add-user.html',
  styleUrls: ['./user-manage.component.css']
})
export class DialogUserComponent {

  message = false;

  ipacEmailPattern = '[a-zA-Z0-9]+\.[a-zA-Z0-9]+@indianpac\.com';

  addUserForm: FormGroup;

  /**
   * Add user form error object
   */
  addUserFormErrors = {
    'name': '',
    'email': ''
  };
  /**
   * Add user form Validation messages object
   */
  addUserFormValidationMessages = {
    'name': {
      'required': 'Name is required.'
    },
    'email': {
      'required': 'Email is required.',
      'pattern': 'Please use @indianpac email'
    }
  };

  constructor(
    public dialogRef: MatDialogRef<DialogUserComponent>,
    private _fb: FormBuilder,
    private _user: UsersService,
    private _snack: MatSnackBar
  ) {
    this.buildUserForm();
  }

  buildUserForm() {
    this.addUserForm = this._fb.group({
      'name': ['', [
        Validators.required
      ]],
      'email': ['', [
        Validators.required,
        Validators.pattern(this.ipacEmailPattern)
      ]],
      'is_admin': [false, [
      ]],
      'is_media_admin': [false, [
      ]],
      'is_digital_admin': [false, [
      ]]
    });
    this.addUserForm.valueChanges
      .subscribe(data => this.onAddUserValueChanged(data));
    this.onAddUserValueChanged(); // (re)set validation messages now
  }

  onAddUserValueChanged(data?: any) {
    if (!this.addUserForm) { return; }
    const form = this.addUserForm;
    for (const field in this.addUserFormErrors) {
      // clear previous error message (if any)
      this.addUserFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.addUserFormValidationMessages[field];
        for (const key in control.errors) {
          this.addUserFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  onUserFormSubmit() {
    console.log(this.addUserForm.value);
    const payload = this.addUserForm.value;
    this.addUserForm.disable();
    this.message = true;
    this._user.createUser(payload).subscribe((data: any) => {
      if (!data) {
        this._snack.open('Error while creating user', 'Close', {
          duration: 1000
        });
        this.dialogRef.close();
        return;
      }
      if (data.status === true) {
        this.dialogRef.close('hello');
      }
    });
  }

}
