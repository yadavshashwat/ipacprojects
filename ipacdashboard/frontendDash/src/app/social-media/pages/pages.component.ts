/**
 * @author victor
 * Overview component code
 */
import { Component, OnInit } from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { OverviewService } from "../../services/social-media/overview.service";
import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { switchMap } from 'rxjs/operators';

export interface FansGenderAge {
  gender: string;
  value: number;
}



@Component({
  selector: 'app-pages',
  templateUrl: './pages.component.html',
  styleUrls: ['./pages.component.css']
})
export class PagesComponent implements OnInit {

  displayedColumns: string[] = ['gender', 'value'];
  dataSource: FansGenderAge[];

  ages: any[] = [
    { value: '13-17', viewValue: '13-17' },
    { value: '18-24', viewValue: '18-24' },
    { value: '25-34', viewValue: '25-34' },
    { value: '35-44', viewValue: '35-44' },
    { value: '45-54', viewValue: '45-54' },
    { value: '55-64', viewValue: '55-64' },
    { value: '65+', viewValue: '65+' }
  ];

  // Pie
  public pieChartLabels: string[];
  public pieChartData: number[];
  public pieChartType = 'pie';

  // events
  public chartClicked(e: any): void {
    console.log(e);
  }

  public chartHovered(e: any): void {
    console.log(e);
  }

  private options: any = {
    legend: { position: 'right' }
  };


  selected = this.ages[0].viewValue;

  pd: any = [];
  pdMockFansGenderAge: any = {};
  pageSwitch: string;

  constructor(
    private store: Store<fromStore.State>,
    private _overview: OverviewService,
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit() {
    this.pageSwitch = 'loading';
    const pagePerformance = this.route.paramMap.pipe(
      switchMap((params: ParamMap) =>
        this._overview.fetchOverview(+params.get('id')))
    );

    pagePerformance.subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        this.pd = data;
        this.pageSwitch = 'message';
      } else {
        this.pd = data.result.pop();
        // fans gender age component
        this.pdMockFansGenderAge = this.pd.page_fans_gender_age.pop();
        if (Object.keys(this.pdMockFansGenderAge).length === 0 && this.pdMockFansGenderAge.constructor === Object) {
          this.pageSwitch = 'nodata';
          return;
        }
        this.doFansGenderAgeChart();
        this.pageSwitch = 'active';
      }
    });
  }

  /**
   * @method doFansGenderAgeChart
   * @param this.pdMockFansGenderAge Object
   * Changes the value based on the selection of age group
   */
  doFansGenderAgeChart() {
    const result = <FansGenderAge>{};
    this.dataSource = [];
    const keys = this.returnEntries(this.pdMockFansGenderAge.value);
    const values = this.returnValues(this.pdMockFansGenderAge.value);

    keys.forEach((key, index) => {
      const desiredObject = <FansGenderAge>Object.freeze({
        gender: key,
        value: values[index]
      });
      this.dataSource.push(desiredObject);
    });
    // Assign to the chart
    this.pieChartLabels = keys;
    this.pieChartData = values;
    // console.log(this.pieChartLabels);
    // console.log(this.pieChartData);
  }

  /**
   * @method returnEntries
   * @param dictionary of genders + values
   */

  returnEntries = dictionary => <any>Object.entries(dictionary).map((entry) => this.head(entry));

  /**
   * @method returnValues
   * @param dictionary of genders + values
   */
  returnValues = dictionary => <any>Object.values(dictionary).map((value) => value[`${this.selected}`]);

  /**
   * @method head
   * @param returns the head of the array
   */

  head = array => array[0];

  /**
   * @method ageGroupChanged
   */
  ageGroupChanged(event) {
    this.doFansGenderAgeChart();
  }


  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  navigatePages() {
    this.router.navigate(['dashboards/social-media/page-performance']);
  }

}
