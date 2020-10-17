/**
 * @author victor
 * Overview page component
 */
import {Chart} from 'chart.js';
import {
  Component,
  OnInit,
  ViewChild,
  ChangeDetectorRef,
  AfterViewChecked
} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromStore from '../../reducers';
import {LogoutConfirmed} from "../../actions/auth.actions";
import {
  Router,
  ActivatedRoute
} from '@angular/router';
import {OverviewService} from "../../services/social-media/overview.service";
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import * as chartLabel from 'chart.piecelabel.js';
import {FormControl} from "@angular/forms";
import {STATES} from '../../states-districts';
import {ReplaySubject} from 'rxjs';
import {Subject, forkJoin} from 'rxjs';
import {takeUntil, distinctUntilChanged, debounceTime} from 'rxjs/operators';
import {MatSnackBar} from '@angular/material';
import {ExcelService} from '../../services/excel.service';


export interface OverView {
  page_name: string;
  page_fans: number;
  page_impressions_days_28: number;
  page_views_total_days_28: number;
  page_negative_feedback_days_28: number;
  page_id?: string;
}

@Component({
  selector: 'app-facebook-page-overview',
  templateUrl: './facebook-page-overview.component.html',
  styleUrls: ['./facebook-page-overview.component.css']
})
export class FacebookPageOverviewComponent implements OnInit, AfterViewChecked {

  displayedColumns: string[] = [
    'page_name',
    'page_fans',
    'page_impressions_days_28',
    'page_views_total_days_28',
    'page_negative_feedback_days_28',
    'page_engaged_users_day',
    'page_impressions_unique_day',
    'page_impressions_organic_unique_day',
    'page_impressions_paid_unique_day'
  ];
  dataSourceReal = [];
  dataSource = new MatTableDataSource<OverView>([]);
  newFb = [];

  fbOverviewSwitch: string;
  keyPI: any[];

  panelOpenState = false;
  date = new Date();
  todayTimeStamp = +new Date; // Unix timestamp in milliseconds
  oneDayTimeStamp = 1000 * 60 * 60 * 24; // Milliseconds in a day
  diff = this.todayTimeStamp - this.oneDayTimeStamp;
  yesterdayDate = new Date(this.diff);
  yesterdayString = `${this.yesterdayDate.getFullYear()}-${this.yesterdayDate.getMonth() < 10 ? "0" + (this.yesterdayDate.getMonth() + 1) : (this.yesterdayDate.getMonth() + 1)}-${this.yesterdayDate.getDate() < 10 ? "0" + this.yesterdayDate.getDate() : this.yesterdayDate.getDate()}`;
  overAllLikes = 0;
  likes = 0;
  dislikes = 0;
  likesCity = {};
  impressions = 0;
  engagedUsers = 0;
  nF = 0;

  teams = [
    'NCT', 'DC', 'AP'
  ];

  categories = [
    'National District', 'AP District'
  ];

  // Form controls
  districts: any[];

  // filters object
  filterValues = {
    'page_state': '',
    'page_district': '',
    'page_category': '',
    'page_management': '',
    'page_poc': '',
    'start_date': '',
    'end_date': ''
  };
  /** control for the MatSelect filter keyword */
  public stateFilterCtrl: FormControl = new FormControl();
  /** list of states filtered by search keyword */
  public filteredStates: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** control for the MatSelect filter keyword */
  public districtFilterCtrl: FormControl = new FormControl();
  /** list of districts filtered by search keyword */
  public filteredDistricts: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  stateCtrl: FormControl = new FormControl();
  catCtrl: FormControl = new FormControl();
  teamCtrl: FormControl = new FormControl();
  searchCtrl: FormControl = new FormControl();
  districtCtrl: FormControl = new FormControl({value: '', disabled: true});
  sdCtrl: FormControl = new FormControl({value: '', disabled: true});
  edCtrl: FormControl = new FormControl({value: '', disabled: true});
  states = STATES;

  // States
  public chartOptions: any = {
    legend: {
      position: 'right',
      labels: {
        boxWidth: 15,
        fontFamily: "'Lato'",
        fontStyle: 'bold'
      }
    },
    pieceLabel: {
      render: 'percentage',
      fontSize: 14,
      fontStyle: 'bold',
      fontColor: '#000',
      fontFamily: '"Lato"',
      position: 'outside'
    }
  };
  public chartLineOptions: any = {
    legend: {
      position: 'top',
      labels: {
        boxWidth: 15
      }
    }
  };
  public chartColors: Array<any> = [
    { // first color
      backgroundColor: 'rgba(122,179,23,0.7)',
      borderColor: '#A0C55F',
      pointBackgroundColor: 'rgba(0,0,0,1)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: 'rgba(0,0,0,0.8)',
      pointHoverBorderColor: 'rgba(225,10,24,0.2)'
    },
    { // second color
      backgroundColor: 'rgba(250,42,0,0.7)',
      borderColor: 'rgba(250,42,0,0.9)',
      pointBackgroundColor: 'rgba(0,0,0,1)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: 'rgba(0,0,0,0.8)',
      pointHoverBorderColor: 'rgba(225,10,24,0.2)'
    }
  ];
  // Charts
  public pieChartType = 'pie';
  public lineChartType = 'line';
  public barChartType = 'bar';
  public pieChartImpressLabels: string[];
  public pieChartImpressData: number[];
  // lineChart
  public lineChartLikeData: Array<any> = [];
  public lineChartLikeLabels: Array<any> = [];
  public lineChartImpData: Array<any> = [];
  public lineChartImpLabels: Array<any> = [];
  public lineChartEngData: Array<any> = [];
  public lineChartEngLabels: Array<any> = [];
  public lineChartNfData: Array<any> = [];
  public lineChartNfLabels: Array<any> = [];
  // bar graph
  public barChartLikeData: Array<any> = [];
  public barChartLikeLabels: Array<any> = [];
  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();
  private paginator: MatPaginator;
  private sort: MatSort;

  constructor(
    private store: Store<fromStore.State>,
    private route: ActivatedRoute,
    private router: Router,
    private _overview: OverviewService,
    private cdr: ChangeDetectorRef,
    private _snack: MatSnackBar,
    private _excel: ExcelService
  ) {
    this.fbOverviewSwitch = 'loading';
    this.filteredStates.next(this.states);
    // listen for search field value changes
    this.stateFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterStates();
      });
    // listen for search field value changes
    this.districtFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterDistricts();
      });
    // enable district as per it
    // fetch Data as per state
    this.stateCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.fetchDistrictAndData(data.state);
        this.filterValues['page_state'] = data.state;
        this.fetchForkAPIs(this.filterValues);
      });
    // enable district as per it
    this.districtCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.filterValues['page_district'] = data;
        this.fetchForkAPIs(this.filterValues);
      });
    this.catCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.filterValues['page_category'] = data;
        this.fetchForkAPIs(this.filterValues);
      });
    this.teamCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.filterValues['page_management'] = data;
        this.fetchForkAPIs(this.filterValues);
      })
    // listen for gender control changes
    this.sdCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.filterValues.start_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
        this.fetchForkAPIs(this.filterValues);
      });
    // listen for gender control changes
    this.edCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe((data) => {
        if (!data) {
          return;
        }
        this.filterValues.end_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
        this.fetchForkAPIs(this.filterValues);
      });
    // listen for search control changes
    this.searchCtrl.valueChanges
      .pipe(
        takeUntil(this._onDestroy),
        debounceTime(400),
        distinctUntilChanged()
      ).subscribe((value) => {
      this.filterValues.page_poc = value;
      this.fetchForkAPIs(this.filterValues);
    });
  }

  @ViewChild('paginator') set matPaginator1(mp: MatPaginator) {
    this.paginator = mp;
    this.setDataSourceAttributesYear();
  }

  @ViewChild(MatSort) set matSort(ms: MatSort) {
    this.sort = ms;
    this.setDataSourceAttributesYearSort();
  }

  // events
  public chartClicked(e: any): void {
    console.log(e);
  }

  public chartHovered(e: any): void {
    console.log(e);
  }

  setDataSourceAttributesYear() {
    this.dataSource.paginator = this.paginator;
  }

  setDataSourceAttributesYearSort() {
    this.dataSource.sort = this.sort;
  }

  /**
   * @method fetchForkAPIs
   * @param filterValues
   */
  fetchForkAPIs(payload) {
    this.fbOverviewSwitch = 'filter';
    const overview_daily = this._overview.fetchOverviewDailyParams(payload);
    const overall_metrics = this._overview.fetchOverallMetricParams(payload);

    forkJoin([overview_daily, overall_metrics]).subscribe((data:any) => {
      if (!data) {
        this._snack.open('Error while fetching the data', 'Close', {
          duration: 1000
        });
        this.fbOverviewSwitch = 'nodata';
        return;
      }
      if(!data.status){
        this._snack.open(data.msg,'Close', {
          duration: 1000
        });
        this.fbOverviewSwitch = 'active';
        return;
      }
      if (data[0].results.length === 0 || data[1].results.length === 0) {
        this._snack.open('No data found', 'Close', {
          duration: 1000
        });
        this.fbOverviewSwitch = 'nodata';
        return;
      }

      this.dataSourceReal = data[0].results;
      this.newFb = data[1].results;

      if (this.newFb[0].page_fans[this.yesterdayString] === undefined || this.newFb[1].page_fan_adds[this.yesterdayString] === undefined
        || this.newFb[2].page_fan_removes[this.yesterdayString] === undefined  || this.newFb[4].page_engaged_users[this.yesterdayString] === undefined
        || this.newFb[3].page_impressions[this.yesterdayString] === undefined  || this.newFb[5].page_negative_feedback[this.yesterdayString] === undefined ) {
        this.fbOverviewSwitch = 'notodaydata';
        return;
      }
      this.overAllLikes = this.newFb[0].page_fans[this.yesterdayString];
      this.likes = this.newFb[1].page_fan_adds[this.yesterdayString];
      this.dislikes = this.newFb[2].page_fan_removes[this.yesterdayString];
      this.impressions = this.newFb[3].page_impressions[this.yesterdayString];
      this.engagedUsers = this.newFb[4].page_engaged_users[this.yesterdayString];
      this.nF = this.newFb[5].page_negative_feedback[this.yesterdayString];

      this.doLikeLineGraph();
      this.doLikeBarGraph();
      this.doImpressLineChart();
      this.doEngLineGraph();
      this.doNfLineGraph();
      this.dataSource = new MatTableDataSource<any>(data[0].results);
      this.fbOverviewSwitch = 'active';

    })
  }

  fetchDistrictAndData(value) {
    const districts = this.states.slice().filter((el) => el.state === value).pop();
    this.filteredDistricts.next(districts.districts);
    this.districtCtrl.enable();
  }

  ngAfterViewChecked() {
    this.cdr.detectChanges();
  }

  ngOnInit() {
    Chart.plugins.register(chartLabel);
    const overViewYear = this._overview.fetchOverviewFinal();
    const overviewNew = this._overview.overviewFB();

    forkJoin([overViewYear, overviewNew]).subscribe(results => {
      if (!results[0].hasOwnProperty('results') || !results[1].hasOwnProperty('results')) {
        this.fbOverviewSwitch = 'message';
        return;
      } else {

        this.dataSourceReal = results[0].results;
        this.newFb = results[1].results;
        // likes and dislikes
        if (this.newFb[0].page_fans[this.yesterdayString] === undefined || this.newFb[1].page_fan_adds[this.yesterdayString] === undefined
          || this.newFb[2].page_fan_removes[this.yesterdayString] === undefined  || this.newFb[4].page_engaged_users[this.yesterdayString] === undefined
          || this.newFb[3].page_impressions[this.yesterdayString] === undefined  || this.newFb[5].page_negative_feedback[this.yesterdayString] === undefined ) {
          this.fbOverviewSwitch = 'notodaydata';
          return;
        }
        this.overAllLikes = this.newFb[0].page_fans[this.yesterdayString];
        this.likes = this.newFb[1].page_fan_adds[this.yesterdayString];
        this.dislikes = this.newFb[2].page_fan_removes[this.yesterdayString];
        this.impressions = this.newFb[3].page_impressions[this.yesterdayString];
        this.engagedUsers = this.newFb[4].page_engaged_users[this.yesterdayString];
        this.nF = this.newFb[5].page_negative_feedback[this.yesterdayString];

        this.doLikeLineGraph();
        this.doLikeBarGraph();
        this.doImpressLineChart();
        this.doEngLineGraph();
        this.doNfLineGraph();
        this.dataSource = new MatTableDataSource<any>(results[0].results);
        this.fbOverviewSwitch = 'active';
      }
    });
  }

  /**
   * @method clear filters
   */
  clearFilters() {
    this.filterValues = {
      'page_state': '',
      'page_district': '',
      'page_category': '',
      'page_management': '',
      'page_poc': '',
      'start_date': '',
      'end_date': ''

    };
    this.stateCtrl.setValue('');
    this.districtCtrl.setValue('');
    this.districtCtrl.disable();
    this.teamCtrl.setValue('');
    this.catCtrl.setValue('');
    this.sdCtrl.setValue('');
    this.edCtrl.setValue('');
    this.searchCtrl.setValue('');
    this.ngOnInit();
  }

  /**
   * @method doLikeLineGraph
   */
  doLikeLineGraph() {

    this.lineChartLikeData = [
      {data: Object.values(this.newFb[0].page_fans), label: 'Likes'}
    ];
    this.lineChartLikeLabels = Object.keys(this.newFb[0].page_fans);
  }

  /**
   * @method doLikeLineGraph
   */
  doEngLineGraph() {
    this.lineChartEngData = [
      {data: Object.values(this.newFb[4].page_engaged_users), label: 'Engaged Users'}
    ];
    this.lineChartEngLabels = Object.keys(this.newFb[4].page_engaged_users);
  }

  /**
   * @method doLikeLineGraph
   */
  doNfLineGraph() {
    this.lineChartNfData = [
      {data: Object.values(this.newFb[5].page_negative_feedback), label: 'Negative feedback'}
    ];
    this.lineChartNfLabels = Object.keys(this.newFb[5].page_negative_feedback);
  }

  /**
   * @method doLikeBarGraph
   */
  doLikeBarGraph() {

    this.barChartLikeData = [
      {data: Object.values(this.newFb[1].page_fan_adds), label: 'Likes'},
      {data: Object.values(this.newFb[2].page_fan_removes), label: 'Dislikes'}
    ];

    this.barChartLikeLabels = Object.keys(this.newFb[2].page_fan_removes);
  }

  doImpressLineChart() {
    this.lineChartImpData = [
      {data: Object.values(this.newFb[3].page_impressions), label: 'Impressions'}
    ];
    this.lineChartImpLabels = Object.keys(this.newFb[3].page_impressions);
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
    this.router.navigate(['/']);
  }

  // filter functions
  private filterStates() {
    if (!this.states) {
      return;
    }
    // get the search keyword
    let search = this.stateFilterCtrl.value;
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

  // filter functions
  private filterDistricts() {
    if (!this.districts) {
      return;
    }
    // get the search keyword
    let search = this.districtFilterCtrl.value;
    if (!search) {
      this.filteredDistricts.next(this.districts.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredDistricts.next(
      this.districts.filter(district => district.toLowerCase().indexOf(search) > -1)
    );
  }

  exportAsXLSX(): void {
    this._excel.exportAsExcelFile(this.dataSourceReal, 'state_wise_data');
  }

}
