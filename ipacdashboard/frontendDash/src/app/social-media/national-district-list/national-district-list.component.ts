import {
  Component,
  OnInit,
  ViewChild,
  AfterViewInit
} from '@angular/core';
import { Router } from "@angular/router";
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
  forkJoin
} from 'rxjs';
import { ExcelService } from '../../services/excel.service';

export interface OverView {
  page_name: string;
  page_fans: number;
  page_impressions_days_28: number;
  page_views_total_days_28: number;
  page_negative_feedback_days_28: number;
  page_id?: string;
}


@Component({
  selector: 'app-national-district-list',
  templateUrl: './national-district-list.component.html',
  styleUrls: ['./national-district-list.component.css']
})
export class NationalDistrictListComponent implements OnInit {

  displayedColumns: string[] = ['page_name', 'page_fans', 'page_posts_impressions_days_28', 'page_views_total_days_28', 'page_negative_feedback_days_28'];
  displayedDaily: string[] = ['page_name', 'page_fans', 'page_fan_adds', 'page_posts_impressions_day', 'page_views_total_day', 'page_negative_feedback_day'];
  displayedWeekly: string[] = ['page_name', 'page_fans', 'page_fan_adds', 'page_posts_impressions_week', 'page_views_total_week', 'page_negative_feedback_week'];
  dataSourceReal = [];
  dataSourceDailyReal = [];
  dataSourceWeeklyReal = [];
  dataSource = new MatTableDataSource<any>([]);
  dataSourceDaily = new MatTableDataSource<any>([]);
  dataSourceWeekly = new MatTableDataSource<any>([]);
  overviewSwitch = 'loading';
  selected = 'thisyear';
  states = STATES;
  selectedState = '';
  districts: string[] = [];
  selectedDistrict = '';

  private paginator: MatPaginator;
  private sort: MatSort;
  private otherPaginator: MatPaginator;
  private anotherPaginator: MatPaginator;

  @ViewChild('paginator') set matPaginator1(mp: MatPaginator) {
    this.paginator = mp;
    this.setDataSourceAttributesYear();
  }

  @ViewChild(MatSort) set matSort(ms: MatSort) {
    this.sort = ms;
    this.setDataSourceAttributesYearSort();
  }

  @ViewChild('otherPaginator') set matPaginator2(mp: MatPaginator) {
    this.otherPaginator = mp;
    this.setDataSourceAttributesDaily();
  }

  @ViewChild('anotherPaginator') set matPaginator3(mp: MatPaginator) {
    this.anotherPaginator = mp;
    this.setDataSourceAttributesWeekly();
  }

  setDataSourceAttributesYear() {
    this.dataSource.paginator = this.paginator;
  }

  setDataSourceAttributesYearSort() {
    this.dataSource.sort = this.sort;
    this.dataSourceDaily.sort = this.sort;
    this.dataSourceWeekly.sort = this.sort;
  }

  setDataSourceAttributesDaily() {
    this.dataSourceDaily.paginator = this.otherPaginator;
  }

  setDataSourceAttributesWeekly() {
    this.dataSourceWeekly.paginator = this.anotherPaginator;
  }
  constructor(
    private store: Store<fromStore.State>,
    private _overview: OverviewService,
    private _router: Router,
    private _excel: ExcelService
  ) { }

  exportAsXLSXYear(): void {
    this._excel.exportAsExcelFile(this.dataSourceReal, 'year');
  }

  exportAsXLSXYes(): void {
    this._excel.exportAsExcelFile(this.dataSourceDailyReal, 'yeaterday');
  }

  exportAsXLSXWeek(): void {
    this._excel.exportAsExcelFile(this.dataSourceWeeklyReal, 'week');
  }

  mapDistricts(stateName) {

    this.overviewSwitch = 'filter';

    const selectedState = this.states.filter((stateObj) => {
      return stateObj.state === stateName.value;
    }).pop();

    this.districts = selectedState.districts;

    if (this.selected === 'thisyear') {
      const updatedDataSource = this.dataSourceReal.filter((data) => {
        return data.page_state === stateName.value;
      });
      this.dataSource = new MatTableDataSource<any>(updatedDataSource);
      if (updatedDataSource.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }

    if (this.selected === 'yesterday') {
      const updatedDataSourceDaily = this.dataSourceDailyReal.filter((data) => {
        return data.page_state === stateName.value;
      });
      this.dataSourceDaily = new MatTableDataSource<any>(updatedDataSourceDaily);
      if (updatedDataSourceDaily.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }

    if (this.selected === 'week') {
      const updatedDataSourceWeekly = this.dataSourceWeeklyReal.filter((data) => {
        return data.page_state === stateName.value;
      });
      this.dataSourceWeekly = new MatTableDataSource<any>(updatedDataSourceWeekly);
      if (updatedDataSourceWeekly.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }
  }

  filterData(districtName) {
    const selectedDistrict = this.districts.filter((district) => {
      return district === districtName.value;
    }).pop();

    if (this.selected === 'thisyear') {
      const updatedDataSource = this.dataSourceReal.filter((data) => {
        return data.page_district === districtName.value;
      });
      this.dataSource = new MatTableDataSource<any>(updatedDataSource);
      if (updatedDataSource.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }

    if (this.selected === 'yesterday') {
      const updatedDataSourceDaily = this.dataSourceDailyReal.filter((data) => {
        return data.page_district === districtName.value;
      });
      this.dataSourceDaily = new MatTableDataSource<any>(updatedDataSourceDaily);
      if (updatedDataSourceDaily.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }

    if (this.selected === 'yesterday') {
      const updatedDataSourceWeekly = this.dataSourceWeeklyReal.filter((data) => {
        return data.page_district === districtName.value;
      });
      this.dataSourceDaily = new MatTableDataSource<any>(updatedDataSourceWeekly);
      if (updatedDataSourceWeekly.length !== 0) {
        this.overviewSwitch = 'active';
      } else {
        this.overviewSwitch = 'nodata';
      }
    }
  }

  ngOnInit() {
    const overViewYear = this._overview.fetchOverviewFinalNational();
    const overViewYes = this._overview.fetchOverviewFinalDailyNational();
    const overViewWeek = this._overview.fetchOverviewFinalWeeklyNational();

    forkJoin([overViewYear, overViewYes, overViewWeek]).subscribe(results => {
      if (!results[0].hasOwnProperty('results') || !results[1].hasOwnProperty('results')) {
        this.overviewSwitch = 'message';
        return;
      } else {
        this.overviewSwitch = 'active';
        this.dataSourceReal = results[0].results;
        this.dataSourceDailyReal = results[1].results;
        this.dataSourceWeeklyReal = results[2].results;
        this.dataSource = new MatTableDataSource<any>(results[0].results);
        this.dataSourceDaily = new MatTableDataSource<any>(results[1].results);
        this.dataSourceWeekly = new MatTableDataSource<any>(results[2].results);
      }
    });
  }

  clearFilters() {
    this.overviewSwitch = 'loading';
    this.selectedState = '';
    this.selectedDistrict = '';
    this.districts = [];
    this.dataSource = new MatTableDataSource<any>(this.dataSourceReal);
    this.dataSourceDaily = new MatTableDataSource<any>(this.dataSourceDailyReal);
    this.dataSourceWeekly = new MatTableDataSource<any>(this.dataSourceWeeklyReal);
    this.selected = 'thisyear';
    this.overviewSwitch = 'active';
  }

  invokePaginator(event) {
    if (event.value === 'thisyear') {
      this.dataSource = new MatTableDataSource<any>(this.dataSourceReal);
      return;
    }

    if (event.value === 'yesterday') {
      this.dataSourceDaily = new MatTableDataSource<any>(this.dataSourceDailyReal);
      return;
    }

    if (event.value === 'week') {
      this.dataSourceWeekly = new MatTableDataSource<any>(this.dataSourceWeeklyReal);
      return;
    }
  }


  logout() {
    this.store.dispatch(new LogoutConfirmed());
    this._router.navigate(['/']);
  }

  navigate(row) {
    this._router.navigate(['/dashboards/social-media/national-district', row.page_id]);
  }

}
