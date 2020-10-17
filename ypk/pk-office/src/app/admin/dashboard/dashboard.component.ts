/**
 * @author victor
 * Component for showing the dashboard
 */
import {Component, OnInit, ViewChild} from '@angular/core';
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import {FormControl} from '@angular/forms';
import {JoinPkService} from '../../join-pk.service';
import {MatSnackBar} from '@angular/material';
import {Router} from '@angular/router';


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  displayedColumns: string[] = ['state', 'total_registrations', 'web_form', 'callcenter'];
  dataSource = new MatTableDataSource<any>([]);
  teams: string[] = [
    'All', 'Yes', 'No'
  ];
  teamCtrl: FormControl = new FormControl();
  sdCtrl: FormControl = new FormControl({value: '', disabled: true});
  edCtrl: FormControl = new FormControl({value: '', disabled: true});
  masterData: any;
  public chartLineOptions: any = {
    legend: {
      position: 'top',
      labels: {
        boxWidth: 15
      }
    },
    responsive: true
  };
  overviewSwitch: string;

  // Charts
  public lineChartType = 'line';

  // lineChart
  public lineChartRegData: Array<any> = [];
  public lineChartRegLabels: Array<any> = [];

  // lineChart
  public lineChartFaqData: Array<any> = [];
  public lineChartFaqLabels: Array<any> = [];

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


  // events
  public chartClicked(e: any): void {
    console.log(e);
  }

  public chartHovered(e: any): void {
    console.log(e);
  }

  public filterValues = {
    team: '',
    start_date: '',
    end_date: ''
  };

  constructor(
    private _overview: JoinPkService,
    private _snack: MatSnackBar,
    private _router: Router
  ) {
    this.teamCtrl.valueChanges.subscribe((data) => {
      if (data === '') {
        return;
      }
      if (data === 'All') {
        this.filterValues['team'] = '';
      } else {
        this.filterValues['team'] = data;
      }
      console.log(this.filterValues);
      this.fetchOverview(this.filterValues);
    });
    this.sdCtrl.valueChanges.subscribe((data) => {
      if (data === '') {
        return;
      }
      this.filterValues['start_date'] = this.returnDate(data);
      console.log(this.filterValues);
      this.fetchOverview(this.filterValues);
    });

    this.edCtrl.valueChanges.subscribe((data) => {
      if (data === '') {
        return;
      }
      this.filterValues['end_date'] = this.returnDate(data);
      console.log(this.filterValues);
      this.fetchOverview(this.filterValues);
    });
  }

  returnDate(data) {
    const year = data.getFullYear();
    const month = data.getMonth() + 1;
    const day = data.getDate();
    return `${year}-${month}-${day}`;
  }

  ngOnInit() {
    this.fetchOverview(this.filterValues);
  }

  fetchOverview(payload) {
    // check the filters
    if (payload.start_date !== '' && payload.end_date === '') {
      this._snack.open(`Please select end date too`, 'Close', {
        duration: 2000
      });
      return;
    }
    if (payload.start_date === '' && payload.end_date !== '') {
      this._snack.open(`Please select start date too`, 'Close', {
        duration: 2000
      });
      return;
    }
    this.overviewSwitch = 'loading';

    this._overview.overview(payload).subscribe((response) => {
      if (response.length === 0) {
        this.overviewSwitch = 'nointernet';
        return;
      }
      const result = response;
      if (result.return_status !== 'Success!') {
        this._snack.open(result.summary_data.status, 'Close', {
          duration: 2000
        });
        this.overviewSwitch = 'active';
        return;
      }
      this.masterData = result;
      this.dataSource = new MatTableDataSource<any>(this.masterData.state_wise_summary);
      this.doLineChart();
      this.overviewSwitch = 'active';
    });
  }

  doLineChart() {
    this.lineChartRegData = [
      {data: Object.values(this.masterData.date_reg), label: 'Registrations'}
      // {data: Object.values(this.masterData.date_faq), label: 'Faq'}
    ];

    this.lineChartRegLabels = Object.keys(this.masterData.date_reg);
    this.lineChartFaqData = [
      // {data: Object.values(this.masterData.date_reg), label: 'Registrations'}
      {data: Object.values(this.masterData.date_faq), label: 'Faq'}
    ];

    this.lineChartFaqLabels = Object.keys(this.masterData.date_faq);
  }

  resetData() {
    this.teamCtrl.patchValue('');
    this.filterValues.team = '';
    this.sdCtrl.patchValue('');
    this.filterValues.start_date = '';
    this.edCtrl.patchValue('');
    this.filterValues.end_date = '';
    this.fetchOverview(this.filterValues);
  }

  navigate(row) {
    this._router.navigate(['/dashboard/', row.state]);
  }

}
