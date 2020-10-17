import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { MessageService } from "../services/message.service";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class NewsCategoryService {

  constructor(private http: HttpClient, private message: MessageService) { }

  getTopics(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_news_categories/`)
      .pipe(
        tap(topics => this.log('fetched topics')),
        catchError(this.handleError('getTopics', []))
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
    console.log(`Topics Service:${message}`);
  }
}
