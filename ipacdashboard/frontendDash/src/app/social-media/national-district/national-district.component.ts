/**
 * @author victor
 * Overview component code
 */
import { Component, OnInit, Inject } from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { OverviewService } from "../../services/social-media/overview.service";
import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { switchMap } from 'rxjs/operators';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { Age, FansGender } from "../ap-district/ap-district.component";
import { DialogLikeSourceComponent } from "../ap-district/ap-district.component";

@Component({
  selector: 'app-national-district',
  templateUrl: './national-district.component.html',
  styleUrls: ['./national-district.component.css']
})
export class NationalDistrictComponent implements OnInit {

  date = new Date();
  likes = 0;
  dislikes = 0;
  likesCity = {};
  impressions = 0;
  engagedUsers = 0;
  nF = 0;

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
      position: 'right',
      labels: {
        boxWidth: 15
      }
    }
  };

  // Charts
  public pieChartType = 'pie';
  public lineChartType = 'line';
  public barChartType = 'bar';

  // Pie Gender
  public pieChartGenderLabels: string[];
  public pieChartGenderData: number[];

  public pieChartImpressLabels: string[];
  public pieChartImpressData: number[];

  // Pie Age
  public pieChartAgeLabels: string[];
  public pieChartAgeData: number[];
  public ageChart = false;

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


  // events
  public chartClicked(e: any): void {
    console.log(e);
  }

  public chartHovered(e: any): void {
    console.log(e);
  }

  pd: any = [];
  pdMockFansGenderAge: any = {};
  pageSwitch: string;

  constructor(
    private store: Store<fromStore.State>,
    private _overview: OverviewService,
    private route: ActivatedRoute,
    private router: Router,
    public dialog: MatDialog
  ) { }

  ngOnInit() {
    this.pageSwitch = 'loading';
    const pagePerformance = this.route.paramMap.pipe(
      switchMap((params: ParamMap) =>
        this._overview.fetchOverview(+params.get('id')))
    );

    pagePerformance.subscribe((data) => {
      if (!data.hasOwnProperty('results')) {
        this.pd = data;
        this.pageSwitch = 'message';
      } else {
        this.pd = data.results.slice().pop();
        if (this.pd.page_fans.length > 0) {
          this.date = new Date(this.pd.page_fans.slice().pop().end_time);
        }
        // fans gender age component
        this.pdMockFansGenderAge = this.pd.page_fans_gender_age.slice().pop();
        if (!this.pdMockFansGenderAge) {
          this.pageSwitch = 'message';
          return;
        }
        if (Object.keys(this.pdMockFansGenderAge).length === 0 && this.pdMockFansGenderAge.constructor === Object) {
          this.pageSwitch = 'nodata';
          return;
        }
        // likes and dislikes
        this.likes = this.pd.page_fan_adds.slice().pop().value;
        this.dislikes = this.pd.page_fan_removes.slice().pop().value;
        this.likesCity = this.pd.page_fans_city.slice().pop();
        this.impressions = this.pd.page_posts_impressions_day.slice().pop().value;
        this.engagedUsers = this.pd.page_engaged_users_day.slice().pop().value;
        this.nF = this.pd.page_negative_feedback_day.slice().pop().value;

        this.doFansGenderChart();
        this.doFansAgeChart();
        this.doLikeLineGraph();
        this.doLikeBarGraph();
        this.doImpressLineChart();
        this.doImpressPieChart();
        this.doEngLineGraph();
        this.doNfLineGraph();
        this.pageSwitch = 'active';
      }
    });
  }

  showLikes() {
    const dialogRef = this.dialog.open(DialogLikeSourceComponent, {
      width: '80%',
      height: '80%',
      data: {
        like: this.pd.page_fans_by_like_source.slice().pop().value,
        dislike: this.pd.page_fans_by_unlike_source_unique.slice().pop().value
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log(result);
    });
  }

  /**
   * @method doFansGenderChart
   */
  doFansGenderChart() {
    const desired = <FansGender>{};
    const genderValues = Object.values(this.pdMockFansGenderAge.value);
    const genderKeys = Object.keys(this.pdMockFansGenderAge.value);

    const values = genderValues.map((gender) => {
      return Object.values(gender).reduce((sum, val) => sum + val);
    });
    // Assign to the chart
    this.pieChartGenderLabels = genderKeys;
    this.pieChartGenderData = values;
  }

  /**
   * @method doFansAgeChart
   */
  doFansAgeChart() {
    const desired = <Age>{};
    const ageValues = Object.values(this.pdMockFansGenderAge.value);

    if (ageValues.length < 1) {
      this.ageChart = false;
      return;
    }

    Object.keys(ageValues.slice().pop()).forEach(element => {
      const total = ageValues.reduce((sum: any, obj: Age) => !sum[element] ? sum + obj[element] : sum[element] + obj[element]);
      desired[element] = total;
    });
    // Assign to the chart

    this.pieChartAgeLabels = Object.keys(desired);
    this.pieChartAgeData = Object.values(desired);
    this.ageChart = true;
  }

  /**
   * @method doLikeLineGraph
   */
  doLikeLineGraph() {
    const desired = this.removeDuplicates(this.pd.page_fans, 'end_time');
    const values = desired.map((el) => el.value);
    this.lineChartLikeData = [
      { data: values, label: 'Likes' }
    ];
    this.lineChartLikeLabels = desired.map((el) => new Date(el.end_time).toLocaleDateString());
  }

  /**
   * @method doLikeLineGraph
   */
  doEngLineGraph() {
    const desired = this.removeDuplicates(this.pd.page_engaged_users_day, 'end_time');
    const values = desired.map((el) => el.value);
    this.lineChartEngData = [
      { data: values, label: 'Likes' }
    ];
    this.lineChartEngLabels = desired.map((el) => new Date(el.end_time).toLocaleDateString());
  }

  /**
   * @method doLikeLineGraph
   */
  doNfLineGraph() {
    const desired = this.removeDuplicates(this.pd.page_negative_feedback_day, 'end_time');
    const values = desired.map((el) => el.value);
    this.lineChartNfData = [
      { data: values, label: 'Likes' }
    ];
    this.lineChartNfLabels = desired.map((el) => new Date(el.end_time).toLocaleDateString());
  }

  /**
   * @method doLikeBarGraph
   */
  doLikeBarGraph() {
    const desiredLikes = this.removeDuplicates(this.pd.page_fan_adds_unique_day, 'end_time');
    const valuesLikes = desiredLikes.map((el) => el.value);

    const desiredlUnikes = this.removeDuplicates(this.pd.page_fan_removes_unique_day, 'end_time');
    const valuesUnlikes = desiredlUnikes.map((el) => el.value);

    this.barChartLikeData = [
      { data: valuesLikes, label: 'Likes' },
      { data: valuesUnlikes, label: 'Dislikes' }
    ];

    this.barChartLikeLabels = desiredLikes.map((el) => new Date(el.end_time).toLocaleDateString());
  }

  doImpressLineChart() {
    const desired = this.removeDuplicates(this.pd.page_posts_impressions_day, 'end_time');
    const values = desired.map((el) => el.value);
    this.lineChartImpData = [
      { data: values, label: 'Likes' }
    ];
    this.lineChartImpLabels = desired.map((el) => new Date(el.end_time).toLocaleDateString());
  }

  /**
   * @method doFansGenderChart
   */
  doImpressPieChart() {
    const viral = this.pd.page_posts_impressions_viral_day.slice().pop().value;
    const nonviral = this.pd.page_posts_impressions_nonviral_day.slice().pop().value;
    const organic = this.pd.page_posts_impressions_organic_day.slice().pop().value;
    // Assign to the chart
    this.pieChartImpressLabels = ['Viral', 'Non-Viral', 'Organic'];
    this.pieChartImpressData = [viral, nonviral, organic];
  }

  // Utiliy functions

  removeDuplicates(myArr, prop) {
    return myArr.filter((obj, pos, arr) => {
      return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
    });
  }


  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  navigatePages() {
    this.router.navigate(['dashboards/social-media/national-district']);
  }

}
