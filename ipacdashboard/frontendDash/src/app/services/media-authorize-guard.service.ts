import { Injectable } from '@angular/core';
import {
  CanActivate,
  Router
} from "@angular/router";
import * as fromStore from '../reducers';
import { Store } from "@ngrx/store";
import { of } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class MediaAuthorizeGuardService implements CanActivate {

  user: any;
  constructor(
    private _router: Router,
    private _store: Store<fromStore.State>
  ) {
    this._store.select(fromStore.selectAuthUser).subscribe((data) => {
      if (data !== null) {
        this.user = data.user;
      }
    });
  }

  canActivate() {
    return of(this.user.is_admin || this.user.is_media_admin || !this.user.is_media);
  }
}
