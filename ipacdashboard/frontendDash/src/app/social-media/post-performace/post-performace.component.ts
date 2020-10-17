/**
 * @author victor
 * Overview component code
 */
import {
  Component,
  OnInit,
  ViewChild
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
export interface OverView {
  page_name: string;
  page_fans: number;
  page_posts_impressions_days_28: number;
  page_views_total_days_28: number;
  page_negative_feedback_days_28: number;
  page_id?: string;
}


@Component({
  selector: 'app-post-performace',
  templateUrl: './post-performace.component.html',
  styleUrls: ['./post-performace.component.css']
})
export class PostPerformaceComponent implements OnInit {

  displayedColumns: string[] = ['page_name', 'post_link', 'post_impressions', 'post_likes'];
  dataSourceReal = [];
  dataSourceDailyReal = [];
  dataSource = new MatTableDataSource();
  dataSourceDaily = [];
  postPerformanceSwitch: string;
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

  setDataSourceAttributesYear() {
    this.dataSource.paginator = this.paginator;
  }

  setDataSourceAttributesYearSort() {
    this.dataSource.sort = this.sort;
  }

  constructor(
    private store: Store<fromStore.State>,
    private _overview: OverviewService
  ) { }

  mapDistricts(stateName) {
    const selectedState = this.states.filter((stateObj) => {
      return stateObj.state === stateName.value;
    }).pop();
    this.districts = selectedState.districts;
    if (this.selected === 'thisyear') {
      const updatedDataSource = this.dataSourceReal.filter((data) => {
        return data.page_state === stateName.value;
      });
      this.dataSource = new MatTableDataSource(updatedDataSource);
    }

    if (this.selected === 'yesterday') {
      const updatedDataSourceDaily = this.dataSourceDailyReal.filter((data) => {
        return data.page_state === stateName.value;
      });
      this.dataSourceDaily = updatedDataSourceDaily;
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
      this.dataSource = new MatTableDataSource(updatedDataSource);
    }

    if (this.selected === 'yesterday') {
      const updatedDataSourceDaily = this.dataSourceDailyReal.filter((data) => {
        return data.page_district === districtName.value;
      });
      this.dataSourceReal = updatedDataSourceDaily;
    }
  }

  ngOnInit() {
    this.postPerformanceSwitch = 'loading';
    this._overview.fetchPostPerformance().subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        this.postPerformanceSwitch = 'message';
      } else {
        this.dataSourceReal = data.result;
        this.dataSource = new MatTableDataSource(data.result);
        this.postPerformanceSwitch = 'active';
      }
    });
  }

  clearFilters() {
    this.dataSource = new MatTableDataSource(this.dataSourceReal);
  }


  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

}
