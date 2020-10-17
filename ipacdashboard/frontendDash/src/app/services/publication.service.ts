/**
 * @author Victor
 * Services for fetching publications
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class PublicationService {

  constructor(
    private http: HttpClient
  ) { }

  getPublication(): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_publication/`)
      .pipe(
        tap(states => this.log('fetched publications')),
        catchError(this.handleError('getPublications Error', []))
      );
  }

  getPublicationPaginate(pageNumber, pageSize): Observable<any> {
    return this.http.get(`${API_URL}fetch_all_publication/?page_num=${pageNumber}&page_size=${pageSize}`)
      .pipe(
        tap(states => this.log('fetched publications')),
        catchError(this.handleError('getPublications Error', []))
      );
  }

  addPublication(publiPayload: {
    media_name: any,
    article_type: any,
    title_str_name: any,
    author_str_name: any,
    summary_str_name: any,
    link_str_name: any,
    page_content_str: any,
    is_active: any,
    pubdate_str_name: any,
    lang: any,
    author_content_str: any,
    parties: any,
    leaders: any,
    rss_feed: any,
  }): Observable<any> {
    console.log(publiPayload.is_active);
    const active = publiPayload.is_active ? '1' : '0';
    console.log(active);
    return this.http.get(`${API_URL}add_update_delete_media/?media_name=${publiPayload.media_name}&article_type=${publiPayload.article_type}&rss_feed=${publiPayload.rss_feed}&inclination_party=${publiPayload.parties}&inclination_leader=${publiPayload.leaders}&title_str_name=${publiPayload.title_str_name}&author_str_name=${publiPayload.author_str_name}&summary_str_name=${publiPayload.summary_str_name}&link_str_name=${publiPayload.link_str_name}&page_content_str=${publiPayload.page_content_str}&is_active=${active}&pubdate_str_name=${publiPayload.pubdate_str_name}&lang=${publiPayload.lang}&author_content_str=${publiPayload.author_content_str}`)
      .pipe(
        tap(states => this.log('added publications')),
        catchError(this.handleError('addPublication Error', []))
      );
  }

  editPublication(publiPayload: {
    id: any,
    media_name: any,
    article_type: any,
    title_str_name: any,
    author_str_name: any,
    summary_str_name: any,
    link_str_name: any,
    page_content_str: any,
    is_active: any,
    pubdate_str_name: any,
    lang: any,
    author_content_str: any,
    parties: any,
    leaders: any,
    rss_feed: any,
  }): Observable<any> {
    console.log(publiPayload.is_active);
    const active = publiPayload.is_active ? '1' : '0';
    console.log(active);
    return this.http.get(`${API_URL}add_update_delete_media/?media_id=${publiPayload.id}&media_name=${publiPayload.media_name}&article_type=${publiPayload.article_type}&rss_feed=${publiPayload.rss_feed}&inclination_party=${publiPayload.parties}&inclination_leader=${publiPayload.leaders}&title_str_name=${publiPayload.title_str_name}&author_str_name=${publiPayload.author_str_name}&summary_str_name=${publiPayload.summary_str_name}&link_str_name=${publiPayload.link_str_name}&page_content_str=${publiPayload.page_content_str}&is_active=${active}&pubdate_str_name=${publiPayload.pubdate_str_name}&lang=${publiPayload.lang}&author_content_str=${publiPayload.author_content_str}`)
      .pipe(
        tap(states => this.log('edited publications')),
        catchError(this.handleError('editPublication Error', []))
      );
  }

  deletePublication(publiPayload: {
    id: any
  }): Observable<any> {
    return this.http.get(`${API_URL}add_update_delete_media/?media_id=${publiPayload.id}&is_delete=1`)
      .pipe(
        tap(states => this.log('edited publications')),
        catchError(this.handleError('editPublication Error', []))
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
    console.log(`Publication Service:${message}`);
  }
}
