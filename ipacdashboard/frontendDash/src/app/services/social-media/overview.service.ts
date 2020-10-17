/**
 * @author victor
 * Service for fetching data to overview page
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class OverviewService {

  constructor(
    private http: HttpClient
  ) { }

  /**
   * @method fetchOverview
   */
  fetchOverview(id): Observable<any> {
    return this.http.get(`${API_URL}social/fetch_facebook_page/?page_id=${id}`)
      .pipe(
        tap(states => this.log('fetched Overview')),
        catchError(this.handleError('fetchOverview() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinal(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_daily/`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalNational(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview/?page_category=National District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }


  /**
   * @method fetchOverview
   */
  fetchOverviewFinalAp(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview/?page_category=AP District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }
  /**
   * @method fetchOverview
   */
  fetchOverviewFinalDaily(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_daily/`)
      .pipe(
        tap(states => this.log('fetched scoial overview daily')),
        catchError(this.handleError('fetchOverviewFinalDaily() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalDailyNational(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_daily/?page_category=National District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalDailyAp(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_daily/?page_category=AP District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalWeekly(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_weekly/`)
      .pipe(
        tap(states => this.log('fetched scoial overview Weekly')),
        catchError(this.handleError('fetchOverviewFinalWeekly() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalWeeklyNational(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_weekly/?page_category=National District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }

  /**
   * @method fetchOverview
   */
  fetchOverviewFinalWeeklyAp(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_page_overview_weekly/?page_category=AP District`)
      .pipe(
        tap(states => this.log('fetched scoial overview')),
        catchError(this.handleError('fetchOverviewFinal() Method Error', []))
      );
  }


  /**
   * @method fetchOverview
   */
  fetchPostPerformance(): Observable<any> {
    return this.http.get(`${API_URL}facebook_post_performance/`)
      .pipe(
        tap(states => this.log('fetched scoial post performance ')),
        catchError(this.handleError('fetchPostPerformance() Method Error', []))
      );
  }

  /**
   * @method updateFbOverview
   * @param overview
   */
  updateFbOverview(overview): Observable<any> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');
    let body: HttpParams;
    body = new HttpParams()
      .set('page_id', overview.id)
      .set('page_state', overview.state)
      .set('page_district', overview.district)
      .set('page_category', overview.category);

    return this.http.post(`${API_URL}social/facebook_page_update/`, body.toString(), { headers })
      .pipe(
        tap(data => this.log('updated page data')),
        catchError(this.handleError('updateFbOverview() Method Error', []))
      );
  }

  /**
   * @method schedulerPages
   * @param overview
   */
  schedulerPages(overview: { page_name: string, page_state: string, page_district: string }): Observable<any> {
    let body: HttpParams;
    body = new HttpParams()
      .set('page_name', overview.page_name)
      .set('page_state', overview.page_state)
      .set('page_district', overview.page_district);

    return this.http.get(`${API_URL}social/facebook_page_filter/`, { params: body })
      .pipe(
        tap(data => this.log('scheduled page data')),
        catchError(this.handleError('schedulerPages() Method Error', []))
      );
  }

  /**
   * @method pageExposure
   */
  pageExposure(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_pages_exposure/`)
      .pipe(
        tap(data => this.log('got page Exposure data')),
        catchError(this.handleError('error in pageExposure() method', []))
      );
  }

  /**
   * @method demographicBreakDown
   */
  demographicBreakDown(): Observable<any> {
    return this.http.get(`${API_URL}social/facebook_demographic_breakdown/`)
      .pipe(
        tap(data => this.log('got the demographic data')),
        catchError(this.handleError('demographicBreakDown() error', []))
      );
  }

  /**
   * @method overviewFB
   */
  overviewFB(): Observable<any> {
    return this.http.get(`${API_URL}social/overall_page_metrics/`)
      .pipe(
        tap(data => this.log('got the overview new fb data')),
        catchError(this.handleError('overviewFB() error', []))
      );
  }


  /**
   * @method fetchOverviewDailyParams
   * @params payload
   */
  fetchOverviewDailyParams(payload): Observable<any>{
    let body = new HttpParams();
    body = body.append('page_state', payload.page_state);
    body = body.append('page_district', payload.page_district);
    body = body.append('page_category', payload.page_category);
    body = body.append('page_management', payload.page_management);
    body = body.append('page_poc', payload.page_poc);
    body = body.append('start_date', payload.start_date);
    body = body.append('end_date', payload.end_date);

    return this.http.get(`${API_URL}social/facebook_page_overview_daily/`, {params: body})
      .pipe(
        tap(data => this.log('Fetched overview page daily with params')),
        catchError(this.handleError('fetchOverviewDailyParams() Error',[]))
      );

  }

  /**
   * @method fetchOverviewDailyParams
   * @params payload
   */
  fetchOverallMetricParams(payload): Observable<any>{
    let body = new HttpParams();
    body = body.append('page_state', payload.page_state);
    body = body.append('page_district', payload.page_district);
    body = body.append('page_category', payload.page_category);
    body = body.append('page_management', payload.page_management);
    body = body.append('page_poc', payload.page_poc);
    body = body.append('start_date', payload.start_date);
    body = body.append('end_date', payload.end_date);

    return this.http.get(`${API_URL}social/overall_page_metrics/`, {params: body})
      .pipe(
        tap(data => this.log('Fetched overview page daily with params')),
        catchError(this.handleError('fetchOverviewDailyParams() Error',[]))
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
