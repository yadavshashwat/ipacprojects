/**
 * @author Victor
 * Services for fetching states
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpParams } from '@angular/common/http';
import {
    catchError,
    tap
} from 'rxjs/operators';

@Injectable({
    providedIn: 'root'
})

export class StateService {

    constructor(private http: HttpClient) { }

    getStates(): Observable<any> {
        return this.http.get(`${API_URL}fetch_segments/?dashboard=media&is_active=1&segment_type=state`)
            .pipe(
                tap(states => this.log('fetched states')),
                catchError(this.handleError('getStates', []))
            );
    }

    getDist(payload): Observable<any> {
        let body = new HttpParams();
        body = body.append('state_ids', payload);
        return this.http.get(`${API_URL}fetch_state_district/`, { params: body})
            .pipe(
                tap(districts => this.log('fetched districts')),
                catchError(this.handleError('getDist', []))
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
        console.log(`State Service:${message}`);
    }
}
