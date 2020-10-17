/**
 * @author victor
 * Component for the showing charts
 */
import {
  Component,
  OnInit
} from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
@Component({
  selector: 'app-analysis',
  templateUrl: './analysis.component.html',
  styleUrls: ['./analysis.component.css']
})
export class AnalysisComponent implements OnInit {

  constructor(
    private store: Store<fromStore.State>
  ) { }

  ngOnInit() {
  }
  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

}
