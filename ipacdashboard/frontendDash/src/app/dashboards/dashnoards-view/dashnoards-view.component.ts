/**
 * @author victor
 * Dashboard view component
 */
import { Component, OnInit } from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
@Component({
  selector: 'app-dashnoards-view',
  templateUrl: './dashnoards-view.component.html',
  styleUrls: ['./dashnoards-view.component.css']
})
export class DashnoardsViewComponent implements OnInit {
  user: any;
  showFiller = false;
  constructor(
    private store: Store<fromStore.State>
  ) { }

  ngOnInit() {
    this.store.select(fromStore.selectAuthUser).subscribe((data) => {
      if (data !== null) {
        this.user = data.user;
      }
    });
  }

}
