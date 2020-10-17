/**
 * @author victor
 * Whole app module
 * Which is crucial in guiding the compilation process
 */
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { LocationStrategy, PathLocationStrategy } from "@angular/common";
import { environment } from '../environments/environment';
import { localStorageSync } from "ngrx-store-localstorage";

// ngRx
import {
  StoreModule,
  ActionReducer,
  MetaReducer
} from "@ngrx/store";
import { StoreDevtoolsModule } from '@ngrx/store-devtools';
import { EffectsModule } from '@ngrx/effects';
import { reducers } from './reducers';
// end of ngRx
import { ClickStopPropagationDirective } from './directives/common/click-stop-propagation.directive';
import { MatButtonModule } from '@angular/material/button';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';

/**
 * Syncing the app state with local storage
 * A brief about local storage:
 * localStorage: 2.5+ M.B depending on the browser,
 * Not sent in every request,
 * data retains if browser and tabs are closed (which is very important)
 * Interview question h bc !!
 */

export function localStorageSyncReducer(reducer: ActionReducer<any>): ActionReducer<any> {
  return localStorageSync({ keys: ['auth'], rehydrate: true })(reducer);
}

const metaReducers: Array<MetaReducer<any, any>> = [localStorageSyncReducer];

@NgModule({
  declarations: [
    AppComponent,
    ClickStopPropagationDirective
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    StoreModule.forRoot(reducers, { metaReducers }),
    StoreDevtoolsModule.instrument({
      name: 'dashboard state',
      logOnly: environment.production,
    }),
    EffectsModule.forRoot([]),
    MatButtonModule,
    MatToolbarModule,
    MatSidenavModule,
    MatListModule,
    MatIconModule
  ],
  providers: [{ provide: LocationStrategy, useClass: PathLocationStrategy }],
  bootstrap: [AppComponent],
  entryComponents: []
})
export class AppModule { }
