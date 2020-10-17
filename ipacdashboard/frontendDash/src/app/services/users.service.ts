/**
 * @author victor
 * Service for fetching all users
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import {
  HttpClient,
  HttpParams
} from '@angular/common/http';
import {
  catchError,
  tap
} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class UsersService {

  constructor(
    private http: HttpClient
  ) { }

  /**
   * @method getUsers
   * get all users
   */
  getUsers(pageNumber: number, pageSize: number): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_staff/?page_num=${pageNumber}&page_size=${pageSize}`)
      .pipe(
        tap(states => this.log('fetched users')),
        catchError(this.handleError('getUsers', []))
      );
  }

  getAll(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_staff/`)
      .pipe(
        tap(states => this.log('fetched users')),
        catchError(this.handleError('getUsers', []))
      );
  }

  updateUser(segment, client): Observable<any> {

    const segmentRead = segment.read ? '1' : '0';
    const segmentWrite = segment.write ? '1' : '0';

    const params = new HttpParams()
      .set('name', client.name)
      .set('email', client.user_email)
      .set('media_segment_id', segment.segmentation_id)
      .set('media_read', segmentRead)
      .set('media_write', segmentWrite);

    return this.http.get(`${API_URL}create_update_user/`, { params })
      .pipe(
        tap(users => this.log('Updated users')),
        catchError(this.handleError('updateUser', []))
      );
  }

  updateMediaAdmin(client): Observable<any> {

    const admin = client.is_admin ? '1' : '0';
    const mediaAdmin = client.is_media_admin ? '1' : '0';

    const params = new HttpParams()
      .set('name', client.name)
      .set('email', client.user_email)
      .set('is_admin', admin)
      .set('is_media_admin', mediaAdmin);

    return this.http.get(`${API_URL}create_update_user/`, { params })
      .pipe(
        tap(users => this.log('Updated users')),
        catchError(this.handleError('updateUser', []))
      );
  }

  updateMediaWriteAPI(client): Observable<any> {

    const admin = client.is_admin ? '1' : '0';
    const mediaAdmin = client.is_media_admin ? '1' : '0';
    const mediaWrite = client.is_media_write ? '1' : '0';

    const params = new HttpParams()
      .set('name', client.name)
      .set('email', client.user_email)
      .set('is_admin', admin)
      .set('is_media_admin', mediaAdmin)
      .set('is_media_write', mediaWrite);

    return this.http.get(`${API_URL}create_update_user/`, { params })
      .pipe(
        tap(users => this.log('Updated users')),
        catchError(this.handleError('updateUser', []))
      );
  }

  updateMediaReadAPI(client): Observable<any> {

    const admin = client.is_admin ? '1' : '0';
    const mediaAdmin = client.is_media_admin ? '1' : '0';
    const mediaWrite = client.is_media_write ? '1' : '0';
    const mediaRead = client.is_media ? '1' : '0';

    const params = new HttpParams()
      .set('name', client.name)
      .set('email', client.user_email)
      .set('is_admin', admin)
      .set('is_media_admin', mediaAdmin)
      .set('is_media_write', mediaWrite)
      .set('is_media', mediaRead);

    return this.http.get(`${API_URL}create_update_user/`, { params })
      .pipe(
        tap(users => this.log('Updated users')),
        catchError(this.handleError('updateUser', []))
      );

  }

  createUser(payload) {
    let body =  new HttpParams();

    body = body.append('name', payload.name);
    body = body.append('email', payload.email);
    body = body.append('is_admin', payload.is_admin ? '1' : '0');
    body = body.append('is_media_admin', payload.is_media_admin ? '1' : '0');
    body = body.append('is_digital_admin', payload.is_digital_admin ? '1' : '0');

    return this.http.get(`${API_URL}create_update_user/`, { params: body })
      .pipe(
        tap(users => this.log('created user')),
        catchError(this.handleError('createUser()', []))
      );

  }

  deleteUser(id) {
    let body =  new HttpParams();

    body = body.append('user_id', id);

    return this.http.get(`${API_URL}delete_user/`, { params: body })
      .pipe(
        tap(users => this.log('deleted user')),
        catchError(this.handleError('deleteUser()', []))
      );

  }
  updateAccess(payload) {
    let body =  new HttpParams();

    body = body.append('name', payload.name);
    body = body.append('email', payload.user_email);
    body = body.append('is_admin', payload.is_admin ? '1' : '0');
    body = body.append('is_media_admin', payload.is_media_admin ? '1' : '0');
    body = body.append('is_digital_admin', payload.is_digital_admin ? '1' : '0');

    return this.http.get(`${API_URL}create_update_user/`, { params: body })
      .pipe(
        tap(users => this.log('update user')),
        catchError(this.handleError('updateAccess()', []))
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
    console.log(`User Service:${message}`);
  }

}
