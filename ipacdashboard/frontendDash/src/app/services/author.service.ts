/**
 * @author Victor
 * Services for fetching authors
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { MessageService } from "../services/message.service";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthorService {

  constructor(
    private http: HttpClient
  ) { }

  /**
   * Fetch All Authors
   */
  getAuthor(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_authors/`)
      .pipe(
        tap(states => this.log('fetched authors')),
        catchError(this.handleError('getAuthor() Method Error', []))
      );
  }

  /**
   * Fetch All Authors
   */
  getAuthorPaginate(pageNumber, pageSize): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_authors/?page_num=${pageNumber}&page_size=${pageSize}`)
      .pipe(
        tap(states => this.log('fetched authors')),
        catchError(this.handleError('getAuthor() Method Error', []))
      );
  }
  /**
   * Add Author
   */
  addAuthor(authorPayload: {
    media_name: any[],
    author_name: string,
    parties: any[],
    leaders: any[]
  }): Observable<any> {
    return this.http.get(`${API_URL}add_update_delete_author/?media_name=${authorPayload.media_name}&author_name=${authorPayload.author_name}&inclination_party=${authorPayload.parties}&inclination_leader=${authorPayload.leaders}`)
      .pipe(
        tap(states => this.log('Add author')),
        catchError(this.handleError('addAuthor() Method Error', []))
      );
  }

  /**
   * Edit Author
   */
  editAuthor(authorPayload: {
    id: any,
    media_name: any[],
    author_name: string,
    parties: any[],
    leaders: any[]
  }): Observable<any> {
    return this.http.get(`${API_URL}add_update_delete_author/?author_id=${authorPayload.id}&media_name=${authorPayload.media_name}&author_name=${authorPayload.author_name}&inclination_party=${authorPayload.parties}&inclination_leader=${authorPayload.leaders}`)
      .pipe(
        tap(states => this.log('Edit author')),
        catchError(this.handleError('editAuthor() Method Error', []))
      );
  }

  /**
   * delete Author
   */
  deleteAuthor(authorPayload: {
    id: any
  }): Observable<any> {
    return this.http.get(`${API_URL}add_update_delete_author/?author_id=${authorPayload.id}&is_delete=1`)
      .pipe(
        tap(states => this.log('Delete author')),
        catchError(this.handleError('deleteAuthor() Method Error', []))
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
    console.log(`Author Service:${message}`);
  }
}
