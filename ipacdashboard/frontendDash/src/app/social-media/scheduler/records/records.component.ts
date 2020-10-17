/**
 * @author victor
 * Records component to select for scheduling the posts
 * There are event emitters and input binding where communication
 * between the components happens
 * child ----> parent ----> child
 */
import {
  Component,
  OnInit,
  Output,
  EventEmitter,
  ViewChild,
  Inject,
  OnDestroy
} from '@angular/core';
import { OverviewService } from "../../../services/social-media/overview.service";
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import { SelectionModel } from '@angular/cdk/collections';
import { STATES } from "../../../states-districts";
import { SchedulerRequest } from "../../interfaces/scheduler-request";
import { FormControl } from "@angular/forms";
import {
  takeUntil
} from 'rxjs/operators';
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA
} from '@angular/material';

import {
  ReplaySubject,
  Subject
} from "rxjs";

@Component({
  selector: 'app-records',
  templateUrl: './records.component.html',
  styleUrls: ['./records.component.css']
})
export class RecordsComponent implements OnInit, OnDestroy {

  recordSwitch: string;
  pageTableSwitch: string;
  dataSourceReal: any[];
  states = STATES;
  districts = [];
  dataSource = new MatTableDataSource<any>([]);
  selection = new SelectionModel<any>(true, []);
  schedulerPagePayload = <SchedulerRequest>{
    page_name: '',
    page_state: '',
    page_district: ''
  };
  public stateFilter = new FormControl();
  public districtFilter = new FormControl();
  public nameFilter = new FormControl();
  public filterValues = { page_state: [], page_district: '', page_name: '' };

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

  /** Whether the number of selected elements matches the total number of rows. */
  isAllSelected() {
    const numSelected = this.selection.selected.length;
    const numRows = this.dataSource.filter.length === 0 ? this.dataSource.data.length : this.dataSource.filteredData.length;
    return numSelected === numRows;
  }

  mapDistricts(event) {
    if (event.value.length > 1) {
      this.districtFilter.disable();
      this.districtFilter.patchValue('');
      return;
    } else if (event.value.length === 1) {
      this.districtFilter.enable();
      this.districtFilter.patchValue('');
    } else {
      return;
    }

    const currentObject = this.states.filter((state) => {
      return state.state === event.value[0];
    }).pop();
    this.districts = currentObject.districts;
    this.filteredDistricts.next(this.districts.slice());

  }
  /** Selects all rows if they are not all selected; otherwise clear selection. */
  masterToggle() {
    if (this.isAllSelected()) {
      this.selection.clear();
    } else {
      if (this.dataSource.filteredData.length > 0) {
        // this.selection.clear();
        this.dataSource.filteredData.forEach((row) => this.selection.select(row));
      } else {
        // this.selection.clear();
        this.dataSource.data.forEach(row => this.selection.select(row));
      }
    }
  }

  displayedColumns = ['select', 'page_name', 'page_state', 'page_district'];
  shownRecords = [];

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

  @Output() page_selected = new EventEmitter<{ value: boolean, data: Array<PageDigitalMedia> }>();

  constructor(
    private _overview: OverviewService,
    public dialog: MatDialog
  ) {
    this.recordSwitch = 'loading';
    console.log(this.selection);
    console.log(this.dataSource);
    this.selection.onChange.subscribe((data) => {
      if (this.selection.selected.length > 0) {
        this.page_selected.emit({ value: true, data: this.selection.selected });
      } else {
        this.page_selected.emit({ value: false, data: this.selection.selected });
      }
    });

    this.stateFilter.valueChanges.subscribe((values) => {
      this.filterValues['page_state'] = values;

      if (this.filterValues.page_state.length < 1) {
        // check for district and page name
        const districtAndName = this.filterDistAndName(this.dataSourceReal.slice());
        this.dataSource = new MatTableDataSource(districtAndName);
        return;
      }

      // filter states
      const stateFiltered = this.dataSourceReal.slice().filter(
        function(e) {
          return this.indexOf(e.page_state) > -1;
        },
        values
      );

      // filter district and name

      const districtNameFilter = this.filterDistAndName(stateFiltered);
      this.dataSource = new MatTableDataSource(districtNameFilter);
    });

    this.districtFilter.valueChanges.subscribe((value) => {
      this.filterValues['page_district'] = value;

      // filter states
      const stateFiltered = this.dataSourceReal.slice().filter(
        function(e) {
          return this.indexOf(e.page_state) > -1;
        },
        this.filterValues.page_state
      );

      // filter district and name

      const districtNameFilter = this.filterDistAndName(stateFiltered);
      this.dataSource = new MatTableDataSource(districtNameFilter);
      // this.resetDataTable();
    });

    this.nameFilter.valueChanges.subscribe((data) => {
      this.filterValues['page_name'] = data.trim().toLowerCase();

      // filter states
      const stateFiltered = this.dataSourceReal.slice().filter(
        function(e) {
          return this.indexOf(e.page_state) > -1;
        },
        this.filterValues.page_state
      );

      // filter district and name
      let districtNameFilter;
      if (stateFiltered.length > 0) {
        districtNameFilter = this.filterDistAndName(stateFiltered);
      } else {
        districtNameFilter = this.filterDistAndName(this.dataSourceReal.slice());
      }
      this.dataSource = new MatTableDataSource(districtNameFilter);
    });

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


  filterDistAndName (real) {
    return real.filter((el) => {
      return el.page_name.toLowerCase().includes(this.filterValues.page_name) && el.page_district.toString().includes(this.filterValues.page_district);
    });
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


  openDialog(selected): void {
    const dialogRef = this.dialog.open(DialogOverviewExampleDialogComponent, {
      width: '80%',
      height: '80%',
      data: selected
    });

    dialogRef.afterClosed().subscribe(result => {
      this.selection = new SelectionModel(true, result);
      console.log(result);
    });
  }

  ngOnInit() {
    this.fetchSchedulerPages();
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  fetchSchedulerPages() {
    this._overview.schedulerPages(this.schedulerPagePayload).subscribe((data) => {
      if (!data.hasOwnProperty('results')) {
        this.recordSwitch = 'serverinternet';
      } else if (data.hasOwnProperty('results') && data.results.length === 0) {
        this.recordSwitch = 'norecords';
      } else {
        this.dataSourceReal = data.results;
        this.dataSource = new MatTableDataSource(data.results);
        this.recordSwitch = 'active';
        this.pageTableSwitch = 'active';
      }
    });
  }

  resetData() {
    this.stateFilter.patchValue([]);
    this.districtFilter.patchValue('');
    this.districts = [];
    this.nameFilter.patchValue('');
    this.dataSource = new MatTableDataSource(this.dataSourceReal.slice());
  }

}

export interface PageDigitalMedia {
  "page_negative_feedback_day": number;
  "page_category": string;
  "page_views_total_day": number;
  "page_fan_adds": number;
  "page_state": string;
  "page_fans": number;
  "page_name": string;
  "page_district": string;
  "page_id": string;
  "page_impressions_day": number;
}

@Component({
  selector: 'app-dialog-overview-example-dialog',
  templateUrl: 'dialog-overview-example-dialog.html',
  styleUrls: ['./records.component.css']
})
export class DialogOverviewExampleDialogComponent {

  pages: Array<PageDigitalMedia>;

  constructor(
    public dialogRef: MatDialogRef<DialogOverviewExampleDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data) {
    this.pages = data;
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  remove(page) {
    const pages = this.pages.filter((data, index) => {
      return index !== page;
    });
    this.pages = pages;
  }

}
