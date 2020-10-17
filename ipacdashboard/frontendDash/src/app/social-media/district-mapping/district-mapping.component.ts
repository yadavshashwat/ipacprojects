/**
 * @author victor
 * district mapping component code
 */
import {
  Component,
  OnInit,
  ViewChild,
  Inject,
  OnDestroy
} from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { OverviewService } from "../../services/social-media/overview.service";
import { STATES } from "../../states-districts";
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA
} from '@angular/material';
import { MatSnackBar } from '@angular/material';
import {
  FormGroup,
  FormBuilder,
  FormArray,
  Validators
} from '@angular/forms';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { FormControl } from "@angular/forms";
import {
  map,
  startWith,
  takeUntil,
  take
} from 'rxjs/operators';

import {
  ReplaySubject,
  Subject
} from "rxjs";
import { ExcelService } from 'src/app/services/excel.service';


export interface FbPageOverview {
  page_category: string;
  page_district: string;
  page_fans: number;
  page_id: string;
  page_name: string;
  page_negative_feedback_days_28: number;
  page_posts_impressions_days_28: number;
  page_state: string;
  page_views_total_days_28: number;
}

@Component({
  selector: 'app-district-mapping',
  templateUrl: './district-mapping.component.html',
  styleUrls: ['./district-mapping.component.css']
})

export class DistrictMappingComponent implements OnInit {

  districtMappingSwitch: string;
  displayedColumns: string[] = ['page_name', 'page_state', 'page_district', 'page_category', 'action'];
  dataSourceReal = [];
  dataSource = new MatTableDataSource<FbPageOverview>();

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
    private store: Store<fromStore.State>,
    private _overview: OverviewService,
    public dialog: MatDialog,
    public snackBar: MatSnackBar,
    public router: Router,
    private _excel: ExcelService
  ) {

  }

  ngOnInit() {
    this.districtMappingSwitch = 'loading';
    // Make API call to fetch the list of data
    this._overview.fetchOverviewFinal().subscribe((data) => {
      if (!data.hasOwnProperty('results')) {
        this.districtMappingSwitch = 'nodata';
      } else {
        this.dataSourceReal = data.results;
        this.dataSource = new MatTableDataSource(data.results);
        this.districtMappingSwitch = 'active';
      }
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
    this.router.navigate(['/']);
  }

  exportAsXLSX(): void {
    this._excel.exportAsExcelFile(this.dataSourceReal, 'year');
  }


  openDialog(row) {
    // open the dialog
    const dialogRef = this.dialog.open(DialogContentFbDistrictMapComponent, {
      height: '350px',
      width: '400px',
      data: row
    });
    dialogRef.afterClosed().subscribe(result => {
      // show snack bar
      if (typeof (result) !== 'undefined') {
        // Make the API call
        this._overview.updateFbOverview(result).subscribe((data) => {
          this.snackBar.open(data.msg, 'Close', {
            duration: 1000
          });
          this.snackBar.open(`updating the entity`, 'Close', {
            duration: 3000
          });
          this._overview.fetchOverviewFinal().subscribe((dataUpdated) => {
            if (!dataUpdated.hasOwnProperty('results')) {
              this.districtMappingSwitch = 'nodata';
            } else {
              this.dataSourceReal = dataUpdated.results;
              this.dataSource = new MatTableDataSource(dataUpdated.results);
              this.districtMappingSwitch = 'active';
            }
          });
        });
      }
    });
  }

}

export interface CategoryType {
  name: string;
  id: number;
}

@Component({
  selector: 'app-dialog-content-district-map',
  templateUrl: 'dialog-content-district-map.html',
  styleUrls: ['./district-mapping.component.css']
})



export class DialogContentFbDistrictMapComponent implements OnInit, OnDestroy {

  pageData: FbPageOverview;
  states = STATES;
  districts: string[] = [];

  // category dropdown
  categories: CategoryType[] = [
    { name: 'None', id: 0 },
    { name: 'National District', id: 1 },
    { name: 'AP District', id: 2 }
  ];

  // 2 way data binding
  selectedState = '';
  selectedDistrict = '';
  selectedCategory = '0';

  /** control for the MatSelect filter keyword */
  public stateFilterControl: FormControl = new FormControl();

  /** list of banks filtered by search keyword */
  public filteredStates: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);

  /** control for the MatSelect filter keyword */
  public districtFilterControl: FormControl = new FormControl();

  /** list of banks filtered by search keyword */
  public filteredDistricts: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);


  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();

  constructor(
    public dialogRef: MatDialogRef<DialogContentFbDistrictMapComponent>,
    @Inject(MAT_DIALOG_DATA) public data: FbPageOverview
  ) {
    this.pageData = this.data;
    this.selectedState = this.data.page_state;
    if (this.selectedState !== '') {
      const distData = this.states.filter((state) => {
        return state.state === this.selectedState;
      }).pop();
      this.districts = distData.districts;
      this.filteredDistricts.next(this.districts.slice());
    }
    this.selectedDistrict = this.data.page_district;
    this.selectedCategory = this.pageData.page_category === 'National District' ? '1' :
      this.pageData.page_category === 'AP District' ? '2' : '0';
    this.filteredStates.next(this.states.slice());

    this.stateFilterControl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterStates();
      });

    this.districtFilterControl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterDist();
      });
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  private filterStates() {
    if (!this.states) {
      return;
    }
    // get the search keyword
    let search = this.stateFilterControl.value;
    if (!search) {
      this.filteredStates.next(this.states.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredStates.next(
      this.states.filter(state => state.state.toLowerCase().indexOf(search) > -1)
    );
  }
  private filterDist() {
    if (!this.districts) {
      return;
    }
    // get the search keyword
    let search = this.districtFilterControl.value;
    if (!search) {
      this.filteredDistricts.next(this.districts.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredDistricts.next(
      this.districts.filter(district => {
        return district.toLowerCase().indexOf(search) > -1;
      })
    );
  }
  ngOnInit() {

  }

  mapDistricts(event) {
    const distData = this.states.filter((state) => {
      return state.state === event.value;
    }).pop();
    this.districts = distData.districts;
    this.filteredDistricts.next(this.districts.slice());
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  mapData() {
    this.dialogRef.close({
      id: this.data.page_id,
      state: this.selectedState,
      district: this.selectedDistrict,
      category: this.selectedCategory === '2' ? 'AP District' : this.selectedCategory === '1' ? 'National District' : 'None'
    });
  }

}
