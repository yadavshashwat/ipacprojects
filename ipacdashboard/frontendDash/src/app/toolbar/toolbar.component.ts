/**
 * @author victor
 * Top toolbar of the dashboard
 */
import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../reducers';
import { Logout, LogoutConfirmed } from "../actions/auth.actions";

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.css']
})
export class ToolbarComponent implements OnInit {

  @Output() toggle: EventEmitter<any> = new EventEmitter<any>();

  constructor(
    private store: Store<fromStore.State>
  ) { }

  ngOnInit() {
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  toggleD() {
    this.toggle.emit(null);
  }

}
