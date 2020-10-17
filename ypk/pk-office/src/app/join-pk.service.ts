/**
 * @author victor
 * Service for getting the list of parties
 */
import {Injectable} from '@angular/core';
import {API_URL} from './app.constant';
import {Observable, of} from 'rxjs';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {catchError, map, tap} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})

export class JoinPkService {

  constructor(
    private http: HttpClient
  ) {
  }

  getStates(): Observable<any> {
    return this.http.get(`${API_URL}php/state.php`)
      .pipe(
        tap(data => this.log('Got States')),
        catchError(this.handleError('Get states Error', []))
      );
  }

  getdistricts(value): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('state', value);
    console.log(value);

    return this.http.post(`${API_URL}php/district.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Got Districts')),
        catchError(this.handleError('Get districts Error', []))
      );
  }

  getProfession(): Observable<any> {
    return this.http.get(`${API_URL}php/profession.php`)
      .pipe(
        tap(data => this.log('Got profession')),
        catchError(this.handleError('Get profession Error', []))
      );
  }

  getacs(value): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('state', value.state)
      .set('district', value.district);
    console.log(value);
    return this.http.post(`${API_URL}php/ac.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Got acs')),
        catchError(this.handleError('Get acs Error', []))
      );
  }

  getblocks(value): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('state', value.state);
    console.log(value);
    return this.http.post(`${API_URL}php/block.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Got BLocks')),
        catchError(this.handleError('Get blocks Error', []))
      );
  }

  addRecord(value): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('email', value.email)
      .set('phone', value.phone)
      .set('whatsapp', value.whatsapp)
      .set('fullname', value.fullname)
      .set('gender', value.gender)
      .set('state', value.state)
      .set('district', value.district)
      .set('university', value.university)
      .set('ages', value.ages)
      .set('living', value.living)
      .set('studies', value.studies)
      .set('college', value.college)
      .set('profession', value.profession)
      .set('partyworker', value.partyworkers)
      .set('parties', value.parties ? value.parties : '')
      .set('positioninparties', value.positioninparties ? value.positioninparties : '')
      .set('message', value.message);
    console.log(body);
    return this.http.post(`${API_URL}php/registration.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Got user')),
        catchError(this.handleError('Get user Error', []))
      );
  }

  addincompleteRecord(value): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('phone', value.x)
      .set('name', value.y)
    console.log(body);
    return this.http.post(`${API_URL}php/incompleteregistration.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Got user')),
        catchError(this.handleError('Get user Error', []))
      );
  }

  login(payload: { user: string, password: string }): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');
    let body: HttpParams = new HttpParams();
    body = body.append('userid', payload.user);
    body = body.append('password', payload.password);
    return this.http.post(`${API_URL}pkdashboard/php/login.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('User logged in')),
        catchError(this.handleError('login() error', []))
      );
  }

  overview(payload): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');
    let body: HttpParams = new HttpParams();
    body = body.append('team', payload.team);
    body = body.append('start_date', payload.start_date);
    body = body.append('end_date', payload.end_date);
    return this.http.post(`${API_URL}pkdashboard/php/total_registrations_filter_search.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('User logged in')),
        catchError(this.handleError('login() error', []))
      );
  }


  stateData(payload): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');
    let body: HttpParams = new HttpParams();
    body = body.append('state', payload.state);
    body = body.append('team', payload.team);
    body = body.append('start_date', payload.start_date);
    body = body.append('end_date', payload.end_date);
    return this.http.post(`${API_URL}pkdashboard/php/state_filter_data.php`, body.toString(), {headers})
      .pipe(
        tap(data => this.log('Particular state wise data fetched')),
        catchError(this.handleError('stateData() error', []))
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
    console.log(`Leader Service:${message}`);
  }
}
