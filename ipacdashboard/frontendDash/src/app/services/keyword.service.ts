/**
 * @author Victor
 * Services for fetching keywords
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class KeywordService {
  constructor(
    private http: HttpClient
  ) { }

  getAllKeys(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_keywords/`)
      .pipe(
        tap(keys => this.log('Got the keys')),
        catchError(this.handleError('Error while getting keys', []))
      );
  }

  /**
   * Fetch All Authors
   */
  getKeyWord(pageNumber, pageSize): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_keywords/?keyword_type=&page_num=${pageNumber}&page_size=${pageSize}`)
      .pipe(
        tap(states => this.log('fetched keywords')),
        catchError(this.handleError('getKeyWord() Method Error', []))
      );
  }
  /**
   * Add Author
   */
  addKeyWord(keywordPayload: {
    keyword: any[],
    synonyms: any,
    is_active: number,
    keyword_type: any[]
  }): Observable<any> {
    console.log(keywordPayload.is_active);
    const active = keywordPayload.is_active ? '1' : '0';
    console.log(active);
    return this.http.get(`${API_URL}add_update_delete_keyword/?keyword_name=${keywordPayload.keyword}&synonyms=${keywordPayload.synonyms}&is_active=${active}&type=${keywordPayload.keyword_type}`)
      .pipe(
        tap(states => this.log('Add Keyword')),
        catchError(this.handleError('addKeyWord() Method Error', []))
      );
  }

  /**
   * Edit Author
   */
  editKeyWord(keywordPayload: {
    id: any,
    keyword: any[],
    synonyms: any,
    is_active: number,
    keyword_type: any[]
  }): Observable<any> {
    console.log(keywordPayload.is_active);
    const active = keywordPayload.is_active ? '1' : '0';
    console.log(active);
    return this.http.get(`${API_URL}add_update_delete_keyword/?key_id=${keywordPayload.id}&keyword_name=${keywordPayload.keyword}&synonyms=${keywordPayload.synonyms}&is_active=${active}&type=${keywordPayload.keyword_type}`)
      .pipe(
        tap(states => this.log('Edit Keyword')),
        catchError(this.handleError('editKeyWord() Method Error', []))
      );
  }

  /**
   * Edit Author
   */
  deleteKeyword(keyword): Observable<any> {
    const synonyms = JSON.stringify([]);
    return this.http.get(`${API_URL}add_update_delete_keyword/?key_id=${keyword.id}&is_delete=1&synonyms=${synonyms}&keyword_name=''&type=''`)
      .pipe(
        tap(states => this.log('Delete Keyword')),
        catchError(this.handleError('deleteKeyword() Method Error', []))
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
    console.log(`Keyword Service:${message}`);
  }
}
