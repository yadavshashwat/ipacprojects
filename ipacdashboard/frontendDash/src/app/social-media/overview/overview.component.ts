/**
 * @author victor
 * Overview component code
 */
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


export interface OverView {
  page_name: string;
  page_fans: number;
  page_impressions_days_28: number;
  page_views_total_days_28: number;
  page_negative_feedback_days_28: number;
  page_id?: string;
}


@Component({
  selector: 'app-overview',
  templateUrl: './overview.component.html',
  styleUrls: ['./overview.component.css']
})
export class OverviewComponent implements OnInit, AfterViewInit {


  displayedColumns: string[] = ['page_name', 'page_fans', 'page_posts_impressions_days_28', 'page_views_total_days_28', 'page_negative_feedback_days_28'];
  displayedDaily: string[] = ['page_name', 'page_fans', 'page_fan_adds', 'page_posts_impressions_day', 'page_views_total_day', 'page_negative_feedback_day'];
  dataSourceReal = [];
  dataSourceDailyReal = [];
  dataSource = new MatTableDataSource<any>([]);
  dataSourceDaily = new MatTableDataSource<any>([]);
  overviewSwitch = 'loading';
  selected = 'thisyear';
  states = STATES;
  selectedState = '';
  districts: string[] = [];
  selectedDistrict = '';

  private paginator: MatPaginator;
  private sort: MatSort;
  private otherPaginator: MatPaginator;

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

  setDataSourceAttributesYear() {
    this.dataSource.paginator = this.paginator;
  }

  setDataSourceAttributesYearSort() {
    this.dataSource.sort = this.sort;
    this.dataSourceDaily.sort = this.sort;
  }

  setDataSourceAttributesDaily() {
    this.dataSourceDaily.paginator = this.otherPaginator;
  }

  constructor(
    private store: Store<fromStore.State>,
    private _overview: OverviewService,
    private _router: Router
  ) { }

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
  }

  ngOnInit() {
    const overViewYear = this._overview.fetchOverviewFinal();
    const overViewYes = this._overview.fetchOverviewFinalDaily();

    forkJoin([overViewYear, overViewYes]).subscribe(results => {
      if (!results[0].hasOwnProperty('result') || !results[1].hasOwnProperty('result')) {
        debugger;
        this.overviewSwitch = 'message';
        return;
      } else {
        this.overviewSwitch = 'active';
        this.dataSourceReal = results[0].result;
        this.dataSourceDailyReal = results[1].result;
        this.dataSource = new MatTableDataSource<any>(results[0].result);
        this.dataSourceDaily = new MatTableDataSource<any>(results[1].result);
      }
    });
  }

  ngAfterViewInit() { }

  clearFilters() {
    this.overviewSwitch = 'loading';
    this.selectedState = '';
    this.selectedDistrict = '';
    this.districts = [];
    this.dataSource = new MatTableDataSource<any>(this.dataSourceReal);
    this.dataSourceDaily = new MatTableDataSource<any>(this.dataSourceDailyReal);
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
  }


  logout() {
    this.store.dispatch(new LogoutConfirmed());
    this._router.navigate(['/']);
  }

  navigate(row) {
    this._router.navigate(['/dashboards/social-media/page-performance', row.page_id]);
  }

}
