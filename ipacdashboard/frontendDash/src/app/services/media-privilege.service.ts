import { Injectable } from '@angular/core';
import * as fromStore from '../reducers';
import { Store } from "@ngrx/store";
import {
  Observable,
  of
} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MediaPrivilegeService {

  user: any;
  constructor(
    private store: Store<fromStore.State>
  ) {
    this.store.select(fromStore.selectAuthUser).subscribe((data) => {
      if (data !== null) {
        this.user = data.user;
      }
    });
  }

  checkMediaPrivilege(): boolean {
    const access = this.user.is_admin ? true :
      this.user.is_media_admin ? true : false;
    return access;
  }

  checkMediaWrite(): boolean {
    return this.user.is_media_write;
  }

  checkMedia(): boolean {
    return this.user.is_media;
  }
}
