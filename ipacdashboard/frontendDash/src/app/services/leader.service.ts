/**
 * @author victor
 * Service for getting the list of parties
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LeaderService {

  constructor(
    private http: HttpClient
  ) { }

  getLeaders(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_leaders/`)
      .pipe(
        tap(states => this.log('Got Leaders')),
        catchError(this.handleError('Get Leaders Error', []))
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
