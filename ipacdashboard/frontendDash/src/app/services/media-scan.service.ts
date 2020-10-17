/**
 * @author Victor
 * Services for fetching publications
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class MediaScanService {

  constructor(private http: HttpClient) { }

  addnews(payload: {
    scan_id?: string,
    channel_id: string,
    link: string,
    headline: string,
    summary: string,
    content: string,
    author_id: string,
    categories: string,
    segmentation: string,
    districts: string,
    language: string,
    sentiment_pair_leader: string,
    sentiment_pair_party: string
  }): Observable<any> {

    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    if (payload.scan_id) {
      body = new HttpParams()
        .set('channel_id', payload.channel_id)
        .set('link', payload.link)
        .set('headline', payload.headline)
        .set('summary', payload.summary)
        .set('content', payload.content)
        .set('author_id', payload.author_id)
        .set('categories', payload.categories)
        .set('segmentation', payload.segmentation)
        .set('districts', payload.districts)
        .set('language', payload.language)
        .set('sentiment_pair_leader', payload.sentiment_pair_leader)
        .set('sentiment_pair_party', payload.sentiment_pair_party)
        .set('scan_id', payload.scan_id);
    } else {
      body = new HttpParams()
        .set('channel_id', payload.channel_id)
        .set('link', payload.link)
        .set('headline', payload.headline)
        .set('summary', payload.summary)
        .set('content', payload.content)
        .set('author_id', payload.author_id)
        .set('categories', payload.categories)
        .set('segmentation', payload.segmentation)
        .set('districts', payload.districts)
        .set('language', payload.language)
        .set('sentiment_pair_leader', payload.sentiment_pair_leader)
        .set('sentiment_pair_party', payload.sentiment_pair_party);
    }

    return this.http.post(`${API_URL}add_update_delete_scan/`, body.toString(), { headers })
      .pipe(
        tap(states => this.log('media scan post')),
        catchError(this.handleError('add news Error', []))
      );
  }

  // Make separate API call for scraped News
  scrapedNewsSubmit(payload: {
    channel_id: string,
    link: string,
    headline: string,
    summary: string,
    content: string,
    // author_id: string,
    categories: any,
    segmentation: any,
    districts: any,
    language: string,
    sentiment_pair_leader: any,
    sentiment_pair_party: any,
    news_feed_id: string
  }): Observable<any> {

    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('channel_id', payload.channel_id)
      .set('link', payload.link)
      .set('headline', payload.headline)
      .set('summary', payload.summary)
      .set('content', payload.content)
      // .set('author_id', payload.author_id)
      .set('categories', JSON.stringify(payload.categories))
      .set('segmentation', JSON.stringify(payload.segmentation))
      .set('districts', payload.districts)
      .set('language', payload.language)
      .set('sentiment_pair_leader', JSON.stringify(payload.sentiment_pair_leader))
      .set('sentiment_pair_party', JSON.stringify(payload.sentiment_pair_party))
      .set('news_feed_id', payload.news_feed_id);

    return this.http.post(`${API_URL}add_update_delete_scan/`, body.toString(), { headers })
      .pipe(
        tap(states => this.log('media scan post')),
        catchError(this.handleError('add news Error', []))
      );
  }


  deleteScan(payload: {
    id: string
  }): Observable<any> {

    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    let body: HttpParams;

    body = new HttpParams()
      .set('is_delete', '1')
      .set('scan_id', payload.id);

    return this.http.post(`${API_URL}add_update_delete_scan/`, body.toString(), { headers })
      .pipe(
        tap(states => this.log('media scan delete')),
        catchError(this.handleError('delete news Error', []))
      );
  }

  fetchMediaScan(pageNumber, pageSize): Observable<any> {

    return this.http.get(`${API_URL}fetch_all_mediascan/?page_num=${pageNumber}&page_size=${pageSize}&secret_id=ahgsdghsaiughdlashsiuanichskuhlcbnhjsailsyfo8uyy2376547653`)
      .pipe(
        tap(states => this.log('media scan fetch')),
        catchError(this.handleError('fetchMediaScan Error', []))
      );
  }

  fetchMediaScanParams(payload): Observable<any> {
    let body = new HttpParams();

    body = body.append('secret_id', 'ahgsdghsaiughdlashsiuanichskuhlcbnhjsailsyfo8uyy2376547653');

    Object.entries(payload).forEach((entry) => {
      body = body.append(entry[0], entry[1].toString());
    });

    return this.http.get(`${API_URL}fetch_all_mediascan/`, { params: body})
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
    console.log(`Media Scan Service:${message}`);
  }
}
