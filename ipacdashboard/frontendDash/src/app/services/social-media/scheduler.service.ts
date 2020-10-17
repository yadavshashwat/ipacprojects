/**
 * @author victor
 * Service for scheduling data 
 */

import { Injectable } from '@angular/core';
import { API_URL } from "../../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SchedulerService {

  constructor(
    private http: HttpClient
  ) { }

  /**
   * @method schedule
   * @param overview
   */
  schedule(overview): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams();

    Object.entries(overview).forEach((entry) => {
      body = body.append(entry[0], entry[1].toString());
    });

    return this.http.post(`${API_URL}social/facebook_post_scheduling/`, body.toString() , { headers })
      .pipe(
        tap(data => this.log('schduled post success data')),
        catchError(this.handleError('schedule() Method Error', []))
      );
  }


  /**
   * @method scheduledPosts
   * @param payload
   */
  scheduledPosts(payload): Observable<any> {

    let body = new HttpParams();

    Object.entries(payload).forEach((entry) => {
      body = body.append(entry[0], entry[1].toString());
    });

    return this.http.get(`${API_URL}social/jobs/`, { params: body} )
      .pipe(
        tap(data => this.log('Jobs success')),
        catchError(this.handleError('scheduledPosts() Method Error', []))
      );
  }

  /**
   * @method deleteScheduledPosts
   * @param id
   */
  deleteScheduledPosts(id): Observable<any> {

    let body = new HttpParams();

    body = body.append('job_id', id);

    return this.http.delete(`${API_URL}social/jobs/`, { params: body} )
      .pipe(
        tap(data => this.log('Jobs deleted')),
        catchError(this.handleError('deleteScheduledPosts() Method Error', []))
      );
  }

  /**
   * @method getPagesScheduled
   * @param id
   */
  getPagesScheduled(id): Observable<any> {

    let body = new HttpParams();

    body = body.append('job_id', id);

    return this.http.get(`${API_URL}social/scheduled_pages/`, { params: body} )
      .pipe(
        tap(data => this.log('Job pages fetched')),
        catchError(this.handleError('getPagesScheduled() Method Error', []))
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
    console.log(`Overview Service:${message}`);
  }
}
