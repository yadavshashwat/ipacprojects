/**
 * @author Victor
 * Services for fetching scraped news
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ScrapedNewsService {

  constructor(private http: HttpClient) { }

  fetchScrapedNews(pageNumber: number, pageSize: number): Observable<any> {

    return this.http.get(`${API_URL}fetch_news_feed/?keyword_present=1&page_num=${pageNumber}&page_size=${pageSize}`)
      .pipe(
        tap(states => this.log('scraped news fetch')),
        catchError(this.handleError('scraped news Error', []))
      );
  }

  fetchScrapedNewsParams(payload): Observable<any> {
    let body = new HttpParams();

    body = body.append('keyword_present', '1');

    Object.entries(payload).forEach((entry) => {
      body = body.append(entry[0], entry[1].toString());
    });

    return this.http.get(`${API_URL}fetch_news_feed/`, { params: body})
      .pipe(
        tap(mediascan => this.log('media scan with params fetched')),
        catchError(this.handleError('error in fetchMediaScanParams', []))
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

  private log(message: string) {
    // this.message.add(`State Service: ${message}`);
    console.log(`Scraped news Service:${message}`);
  }
}
