/**
 * @author Victor
 * Look for the meta data for more information in the decorator
 */
import {
  Component,
  OnInit
} from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";

@Component({
  selector: 'app-media-view',
  templateUrl: './media-view.component.html',
  styleUrls: ['./media-view.component.css']
})
export class MediaViewComponent implements OnInit {

  constructor(
    private store: Store<fromStore.State>
  ) {

  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }
  ngOnInit() {

  }

}
