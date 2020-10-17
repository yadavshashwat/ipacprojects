/**
 * @author victor
 */
import { Injectable } from '@angular/core';
import {
  CanActivate,
  Router
} from "@angular/router";
import {
  map,
  take,
  mergeMap,
  catchError
} from "rxjs/operators";
import { LoginService } from "../services/login.service";
import * as fromStore from '../reducers';
import { Store } from "@ngrx/store";
import { of } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AuthGuardService implements CanActivate {

  constructor(
    private authService: LoginService,
    private store: Store<fromStore.State>,
    private router: Router
  ) { }

  canActivate() {
    return this.checkStoreAuthentication().pipe(
      mergeMap(storeAuth => {
        if (storeAuth) {
          return of(true);
        }
        return this.checkApiAuthentication();
      }),
      map(storeOrApiAuth => {
        if (!storeOrApiAuth) {
          this.router.navigate(['/']);
          return false;
        }
        return true;
      })
    );
  }
  checkStoreAuthentication() {
    return this.store.select(fromStore.selectIsLoggedIn).pipe(take(1));
  }

  checkApiAuthentication() {
    return this.authService.check().pipe(
      map(user => !!user),
      catchError(() => of(false))
    );
  }
}
