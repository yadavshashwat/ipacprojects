/**
 * @author victor, alok
 * Whole app module
 * Which is crucial in guiding the compilation process
 */
import {BrowserModule} from '@angular/platform-browser';
import {NgModule, CUSTOM_ELEMENTS_SCHEMA, LOCALE_ID} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AppComponent} from './app.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {HttpClientModule} from '@angular/common/http';
import {LocationStrategy, HashLocationStrategy, PathLocationStrategy} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {ReactiveFormsModule} from '@angular/forms';
import {MatInputModule} from '@angular/material/input';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatCardModule} from '@angular/material/card';
import {MatRadioModule} from '@angular/material/radio';
import {MatSelectModule} from '@angular/material/select';
import {MatButtonModule} from '@angular/material/button';
import {ThankYouComponent} from './thank-you/thank-you.component';
import {FormComponent, DialogOverviewExampleDialogComponent} from './form/form.component';
import {NgKnifeModule} from 'ng-knife';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatDialogModule} from '@angular/material/dialog';
import {ClickStopPropagationDirective} from './directives/click-stop-propagation.directive';
import {LoginComponent} from './admin/login/login.component';
import {MatIconModule} from '@angular/material/icon';
import {DashboardComponent} from './admin/dashboard/dashboard.component';
import {MatTableModule} from '@angular/material';
import {ChartsModule} from 'ng2-charts';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatNativeDateModule} from '@angular/material';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import {MatPaginatorModule} from '@angular/material/paginator';
import {MatSortModule} from '@angular/material/sort';
import { StateComponent } from './admin/state/state.component';
import { AuthGuard } from './auth.guard';
import { AuthService } from './auth.service';

const appRoutes: Routes = [
  {path: '', component: FormComponent},
  {path: 'admin', component: LoginComponent},
  {path: 'dashboard', component: DashboardComponent, canActivate: [AuthGuard]},
  {path: 'dashboard/:id', component: StateComponent, canActivate: [AuthGuard]}
];


@NgModule({
  declarations: [
    AppComponent,
    ThankYouComponent,
    FormComponent,
    DialogOverviewExampleDialogComponent,
    ClickStopPropagationDirective,
    LoginComponent,
    DashboardComponent,
    StateComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    RouterModule.forRoot(appRoutes),
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule,
    MatFormFieldModule,
    MatCardModule,
    MatRadioModule,
    MatSelectModule,
    MatButtonModule,
    NgKnifeModule,
    MatCheckboxModule,
    MatSnackBarModule,
    MatDialogModule,
    MatIconModule,
    MatTableModule,
    ChartsModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatProgressBarModule,
    MatPaginatorModule,
    MatSortModule
  ],
  providers: [
    {provide: LocationStrategy, useClass: PathLocationStrategy},
    {provide: LOCALE_ID, useValue: 'en-IN'},
    MatNativeDateModule, AuthGuard, AuthService
  ],
  bootstrap: [AppComponent],
  entryComponents: [DialogOverviewExampleDialogComponent],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]
})
export class AppModule {
}
