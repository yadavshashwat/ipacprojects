/**
 * @author victor
 */
import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, ParamMap} from '@angular/router';
import {switchMap} from 'rxjs/operators';
import {JoinPkService} from '../../join-pk.service';
import {
  MatPaginator,
  MatSort,
  MatTableDataSource
} from '@angular/material';
import {FormControl} from '@angular/forms';
import {MatSnackBar} from '@angular/material';


@Component({
  selector: 'app-state',
  templateUrl: './state.component.html',
  styleUrls: ['./state.component.css']
})
export class StateComponent implements OnInit {

  stateDataSwitch: string;

  teams: string[] = [
    'All', 'Yes', 'No'
  ];
  teamCtrl: FormControl = new FormControl();
  sdCtrl: FormControl = new FormControl({value: '', disabled: true});
  edCtrl: FormControl = new FormControl({value: '', disabled: true});

  public filterValues = {
    team: '',
    start_date: '',
    end_date: '',
    state: ''
  };

  dataSourceAge = new MatTableDataSource([]);
  dataSourceDistrict = new MatTableDataSource([]);
  dataSourceGender = new MatTableDataSource([]);
  dataSourceLocation = new MatTableDataSource([]);
  dataSourceParty = new MatTableDataSource([]);
  dataSourcePartyWorker = new MatTableDataSource([]);
  dataSourceProfession = new MatTableDataSource([]);
  dataSourceQualification = new MatTableDataSource([]);

  displayedColumnsAge = ['age', 'total_registrations', 'Online', 'callcenter'];
  displayedColumnsDistrict = ['district', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsGender = ['gender', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsLocation = ['village_or_city', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsParty = ['parties', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsPartyWorker = ['party_worker', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsProfessions = ['profession', 'total_registrations', 'web_form', 'callcenter'];
  displayedColumnsQualification = ['qualification', 'total_registrations', 'web_form', 'callcenter'];

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private _state: JoinPkService,
    private _snack: MatSnackBar
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
      this.fetchStateWiseDataFilter(this.filterValues);
    });
    this.sdCtrl.valueChanges.subscribe((data) => {
      if (data === '') {
        return;
      }
      this.filterValues['start_date'] = this.returnDate(data);
      console.log(this.filterValues);
      this.fetchStateWiseDataFilter(this.filterValues);
    });

    this.edCtrl.valueChanges.subscribe((data) => {
      if (data === '') {
        return;
      }
      this.filterValues['end_date'] = this.returnDate(data);
      console.log(this.filterValues);
      this.fetchStateWiseDataFilter(this.filterValues);
    });
  }

  returnDate(data) {
    const year = data.getFullYear();
    const month = data.getMonth() + 1;
    const day = data.getDate();
    return `${year}-${month}-${day}`;
  }

  ngOnInit() {

    this.route.params.subscribe((params) => {
      this.filterValues.state = params.id;
    });

    this.fetchStateWiseDataFilter(this.filterValues);
  }

  fetchStateWiseDataFilter(payload) {
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
    this.stateDataSwitch = 'loading';
    this._state.stateData(payload).subscribe((data) => {
      console.log(data);
      if (data.length === 0) {
        this.stateDataSwitch = 'nointernet';
      }
      if (!data) {
        this.stateDataSwitch = 'nodata';
      }
      const result = data;
      this.dataSourceAge = new MatTableDataSource<any>(result.state_age);
      this.dataSourceDistrict = new MatTableDataSource<any>(result.state_disctrict);
      this.dataSourceGender = new MatTableDataSource<any>(result.state_gender);
      this.dataSourceLocation = new MatTableDataSource<any>(result.state_location);
      this.dataSourceParty = new MatTableDataSource<any>(result.state_party);
      this.dataSourcePartyWorker = new MatTableDataSource<any>(result.state_party_worker);
      this.dataSourceProfession = new MatTableDataSource<any>(result.state_profession);
      this.dataSourceQualification = new MatTableDataSource<any>(result.state_qualification);
      this.stateDataSwitch = 'active';
    });
  }

  navigateBack() {
    this.router.navigate(['/dashboard']);
  }

  resetData() {
    this.teamCtrl.patchValue('');
    this.filterValues.team = '';
    this.sdCtrl.patchValue('');
    this.filterValues.start_date = '';
    this.edCtrl.patchValue('');
    this.filterValues.end_date = '';
    this.fetchStateWiseDataFilter(this.filterValues);
  }

}
