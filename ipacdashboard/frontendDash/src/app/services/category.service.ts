/**
 * @author victor
 * Category service
 */
import { Injectable } from '@angular/core';
import { Observable, of } from "rxjs";
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { API_URL } from "../app.constant";
import { tap, catchError } from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(
    public http: HttpClient
  ) { }

  fetchAllCategories(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_news_categories/`)
      .pipe(
        tap(cat => this.log('fetched categoris')),
        catchError(this.handleError('fetchAllCategories() error', []))
      );
  }

  addCat(payload): Observable<any> {
    let body = new HttpParams();

    body = body.append('category', payload.category);
    body = body.append('category_desription', payload.description);

    return this.http.get(`${API_URL}add_update_delete_category/`, { params: body})
      .pipe(
        tap(cat => this.log('addded categoris')),
        catchError(this.handleError('addCat() error', []))
      );
  }

  editCat(payload): Observable<any> {
    let body = new HttpParams();

    body = body.append('category', payload.category);
    body = body.append('category_desription', payload.description);
    body = body.append('key_id', payload.id);

    return this.http.get(`${API_URL}add_update_delete_category/`, { params: body})
      .pipe(
        tap(cat => this.log('addded categoris')),
        catchError(this.handleError('addCat() error', []))
      );
  }

  deleteCat(id): Observable<any> {
    let body = new HttpParams();
    body = body.append('key_id', id);
    body = body.append('is_delete', '1');

    return this.http.get(`${API_URL}add_update_delete_category/`, { params: body})
      .pipe(
        tap(cat => this.log('deleted categoris')),
        catchError(this.handleError('deleteCat() error', []))
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
    console.log(`Category Service:${message}`);
  }
}
