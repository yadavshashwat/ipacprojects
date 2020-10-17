/**
 * @author victor
 * User management component
 */
import {
  Component,
  OnInit
} from '@angular/core';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import { UsersService } from "../../services/users.service";
import {
  MatSnackBar,
  PageEvent
} from '@angular/material';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  userList: any = [];
  userSwitch: string;
  userAccordionSwitch: string;

  color = 'primary';
  mode = 'query';
  panelOpenState = false;

  // Pagination Variables
  pageNumber: number;
  pageSize: number;
  totalRecords: number;

  displayedColumns: string[] = ['segmentation_id', 'segment_name', 'read', 'write'];

  constructor(
    private store: Store<fromStore.State>,
    private _user: UsersService,
    private _snackBar: MatSnackBar
  ) {
    this.pageNumber = 1;
    this.pageSize = 10;
  }

  pageEvent(event: PageEvent) {
    this.userAccordionSwitch = 'loading';
    this.pageNumber = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    this._user.getUsers(this.pageNumber, this.pageSize).subscribe((users) => {
      if (!users.hasOwnProperty('result')) {
        this.userList = users;
      } else {
        this.userList = users.result;
      }
      this.userAccordionSwitch = 'active';
    });
  }

  ngOnInit() {
    this.userSwitch = <string>'loading';
    this._user.getUsers(this.pageNumber, this.pageSize).subscribe((users) => {
      if (!users.hasOwnProperty('result')) {
        this.userList = users;
      } else {
        this.userList = users.result;
        this.totalRecords = users.total_records;
      }
      this.userSwitch = <string>'active';
      this.userAccordionSwitch = 'active';
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }


  updateWriteSegment(event, element, client) {
    element.write = event.checked;
    this._user.updateUser(element, client).subscribe((data) => {
      this._snackBar.open(data.Message, 'Close', {
        duration: 3000
      });
      this.userList.forEach((user) => {
        if (user.user_email === client.user_email) {
          user.media_state_access.forEach((segment) => {
            if (segment.segmentation_id === element.segmentation_id) {
              if (segment.write === true) {
                segment.read = true;
              }
            }
          });
        }
      });
    });
  }

  updateReadSegment(event, element, client) {
    element.read = event.checked;
    this._user.updateUser(element, client).subscribe((data) => {
      this._snackBar.open(data.Message, 'Close', {
        duration: 3000
      });
    });
  }

  updateMediaAdmin(event, client) {
    client.is_media_admin = event.checked;
    this._user.updateMediaAdmin(client).subscribe((data) => {
      this._snackBar.open(data.Message, 'Close', {
        duration: 3000
      });
      this.userList.forEach((user) => {
        if (user.user_email === client.user_email) {
          if (user.is_media_admin === true) {
            user.is_media_write = true;
            user.is_media = true;
          }
        }
      });
    });
  }

  updateMediaWrite(event, client) {
    client.is_media_write = event.checked;
    this._user.updateMediaWriteAPI(client).subscribe((data) => {
      this._snackBar.open(data.Message, 'Close', {
        duration: 3000
      });
      this.userList.forEach((user) => {
        if (user.user_email === client.user_email) {
          if (user.is_media_write === true) {
            user.is_media = true;
          }
        }
      });
    });
  }

  updateMediaRead(event,client){
    client.is_media = event.checked;
    this._user.updateMediaReadAPI(client).subscribe((data) => {
      this._snackBar.open(data.Message, 'Close', {
        duration: 3000
      });
    });
  }

  checkReadDisable(element) {
    if (element.write) {
      return true;
    } else {
      return false;
    }
  }

  checkMediaWriteDisable(client) {
    if (client.is_media_admin) {
      return true;
    } else {
      return false;
    }
  }

  checkMediaReadDisable(client) {
    if (client.is_media_write) {
      return true;
    } else {
      return false;
    }
  }

}
