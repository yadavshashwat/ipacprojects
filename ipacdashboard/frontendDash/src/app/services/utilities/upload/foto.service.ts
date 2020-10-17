/**
 * @author victor
 * Service for fetching data to overview page
 */
import { Injectable } from '@angular/core';
import { API_URL } from "../../../app.constant";
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';
import { UploadFotosResponse } from "../../../social-media/scheduler/form/form.component";


@Injectable({
  providedIn: 'root'
})
export class FotoService {

  constructor(
    private http: HttpClient
  ) { }

  uploadToServerImage(files): Observable<any> {
    const formData = new FormData();

    if (files instanceof FileList) {
      const names: string[] = [];
      for (let i = 0; i < files.length; i++) {
        formData.append('file', files[i], files[i].name);
      }
    } else {
      formData.append('file', files, files.name);
    }
    formData.append('filetype', 'image');
    return this.http.post(`${API_URL}social/upload_file/`, formData)
      .pipe(
        tap(data => this.log('got the uploaded fotos data')),
        catchError(this.handleError('uploadToServerImage() error', []))
      );
  }

  uploadToServerVideo(files): Observable<any> {
    const formData = new FormData();

    if (files instanceof FileList) {
      const names: string[] = [];
      for (let i = 0; i < files.length; i++) {
        formData.append('file', files[i], files[i].name);
      }
    } else {
      formData.append('file', files, files.name);
    }
    formData.append('filetype', 'video');
    return this.http.post(`${API_URL}social/upload_file/`, formData)
      .pipe(
        tap(data => this.log('got the uploaded videos data')),
        catchError(this.handleError('uploadToServerVideo() error', []))
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
