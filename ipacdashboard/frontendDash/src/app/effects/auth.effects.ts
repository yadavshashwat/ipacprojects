/**
 * @author victor
 * Effect for authentication state
 */
import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import {
  map,
  exhaustMap,
  catchError,
  tap
} from "rxjs/operators";
import { of, Observable } from "rxjs";
import {
  AuthActionTypes,
  Login,
  LoginSuccess,
  LoginFailure,
  LogoutConfirmed,
  LogoutComplete
} from "../actions/auth.actions";
import { LoginService } from "../services/login.service";
import { Router } from "@angular/router";
import { UserResponse } from "../interfaces/media-dashboard/user-response";
import { MatSnackBar } from "@angular/material";

@Injectable()
export class AuthEffects {
  constructor(
    private actions$: Actions,
    private authService: LoginService,
    private router: Router,
    private _snackbar: MatSnackBar
  ) { }
  @Effect()
  Login: Observable<any> = this.actions$
    .ofType<Login>(AuthActionTypes.Login)
    .pipe(
      map(action => action.payload),
      exhaustMap(auth =>
        this.authService
          .superAdminLogin(auth)
          .pipe(
            map(user => {
              if (user.result.auth) {
                return new LoginSuccess({ user });
              } else {
                return new LoginFailure({ user });
              }
            }),
            catchError(error => of(new LoginFailure(error))),
          ),
      )
    );
  @Effect({ dispatch: false })
  LoginSuccess: Observable<any> = this.actions$
    .ofType<LoginSuccess>(AuthActionTypes.LoginSuccess)
    .pipe(
      tap((data) => {
        this.router.navigate(['/dashboards/list']);
      })
    );

  @Effect({ dispatch: false })
  LoginFailure: Observable<any> = this.actions$
    .ofType<LoginFailure>(AuthActionTypes.LoginFailure)
    .pipe(
      tap((data) => {
        if (data.payload.hasOwnProperty('user')) {
          // show the snack bar
          const userResponse: UserResponse = data.payload.user;
          this._snackbar.open(userResponse.message, 'close', {
            duration: 2000
          });
        } else {
          this._snackbar.open('Either internet or server is down', 'close', {
            duration: 2000
          });
        }
      })
    );

  // @Effect()
  // Logout: Observable<any> = this.actions$
  //   .ofType<Logout>(AuthActionTypes.Logout)
  //   .pipe(
  //     exhaustMap(() =>
  //       this.dialogService
  //         .open(LogoutPromtComponent)
  //         .afterClosed()
  //         .pipe(
  //           map(confirmed => {
  //             if (confirmed) {
  //               return new LogoutConfirmed();
  //             } else {
  //               return new LogoutCancelled();
  //             }
  //           })
  //         ),
  //     ),
  //   );

  @Effect({ dispatch: false })
  LogoutConfirmed: Observable<any> = this.actions$
    .ofType<LogoutConfirmed>(AuthActionTypes.LogoutConfirmed)
    .pipe(
      exhaustMap(auth =>
        this.authService
          .logout()
          .pipe(
            tap(() => {
              this.router.navigate(['/']);
              this._snackbar.open(`Logged out`, 'close', {
                duration: 2000
              });
            }),
            map(() => new LogoutComplete()),
            catchError(() => of(new LogoutComplete())),
          ),
      ),
    );
}
