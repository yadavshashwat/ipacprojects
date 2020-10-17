import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Authenticate } from "../interfaces/authentication/authenticate";

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  private loggedIn = false;
  private userResponse: any;

  constructor(
    private http: HttpClient
  ) { }

  superAdminLogin(auth: Authenticate): Observable<any> {
    return this.http.get(`${API_URL}login_view_staff/?email=${auth.email}&pass=${auth.password}&sec_string=`)
      .pipe(
        tap(userResponse => {
          this.log('User Logged In');
          this.loggedIn = true;
          this.userResponse = userResponse;
          return of(userResponse);
        }),
        catchError(this.handleError('User Login Error', []))
      );
  }

  logout(): Observable<any> {
    return this.http.get(`${API_URL}logout_view_staff/`)
      .pipe(
        tap(userResponse => {
          this.log('User Logged Out');
          this.loggedIn = false;
          return of(userResponse);
        }),
        catchError(this.handleError('User Login Error', []))
      );
  }

  forgot(email): Observable<any> {
    return this.http.get(`${API_URL}send_password_reset/?email=${email}`)
      .pipe(
        tap(userResponse => {
          this.log('forgot link sent');
          return of(userResponse);
        }),
        catchError(this.handleError('User Login Error', []))
      );
  }

  create(pass, secretString): Observable<any> {
    return this.http.get(`${API_URL}reset_pass_staff/?pass=${pass}&sec_string=${secretString}`)
      .pipe(
        tap(userResponse => {
          this.log('create password success!');
          return of(userResponse);
        }),
        catchError(this.handleError('create password Error', []))
      );
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
  /** Log a HeroService message with the MessageService */
  private log(message: string) {
    // this.message.add(`State Service: ${message}`);
    console.log(`Login Service:${message}`);
  }
  check() {
    return of(this.loggedIn ? this.userResponse : null);
  }
}
