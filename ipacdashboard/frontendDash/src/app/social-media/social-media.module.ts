/**
 * @author victor
 * Module for digital media dashboard
 */
import { NgModule, CUSTOM_ELEMENTS_SCHEMA, LOCALE_ID, NO_ERRORS_SCHEMA } from '@angular/core';
import { CommonModule } from '@angular/common';
import { OverviewComponent } from './overview/overview.component';
import { SocialMediaRoutingModule } from "./social-media-routing.module";
import { SocialMediaLinksComponent } from './social-media-links/social-media-links.component';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { MatIconModule } from '@angular/material/icon';
import { FormsModule } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule } from '@angular/forms';
import { MatSelectModule } from '@angular/material/select';
import { MatCardModule } from '@angular/material/card';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatListModule } from '@angular/material/list';
import { PagesComponent } from './pages/pages.component';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { ThousandStuffSuffixesPipe } from "../pipes/thousand-stuff-suffixes.pipe";
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatTableModule } from '@angular/material/table';
import { ChartsModule } from "ng2-charts";
import { PostPerformaceComponent } from './post-performace/post-performace.component';
import { FacebookPageOverviewComponent } from './facebook-page-overview/facebook-page-overview.component';
import { MatSortModule } from '@angular/material/sort';
import {
  DistrictMappingComponent,
  DialogContentFbDistrictMapComponent
} from './district-mapping/district-mapping.component';
import { MatDialogModule } from "@angular/material";
import { MatSnackBarModule } from "@angular/material";
import { NationalDistrictComponent } from './national-district/national-district.component';
import { NationalDistrictListComponent } from './national-district-list/national-district-list.component';
import { ApDistrictComponent, DialogLikeSourceComponent } from './ap-district/ap-district.component';
import { ApDistrictListComponent } from './ap-district-list/ap-district-list.component';
import { SchedulerComponent } from './scheduler/scheduler.component';
import { RecordsComponent, DialogOverviewExampleDialogComponent } from './scheduler/records/records.component';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { SelectedComponent } from './scheduler/selected/selected.component';
import { MatChipsModule } from '@angular/material/chips';
import { FilterComponent } from './scheduler/filter/filter.component';
import { FormComponent } from './scheduler/form/form.component';
import { CovalentFileModule } from '@covalent/core/file';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from "@angular/material";
import { NgxMaterialTimepickerModule } from 'ngx-material-timepicker';
import { MatStepperModule } from '@angular/material/stepper';
import { ScheduledPostsComponent, DialogSeePostDialogComponent } from './scheduled-posts/scheduled-posts.component';
import { MatExpansionModule } from '@angular/material/expansion';
import { NgxMatSelectSearchModule } from 'ngx-mat-select-search';
import { PickerModule } from '@ctrl/ngx-emoji-mart';
import { ExcelService } from '../services/excel.service';




@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    SocialMediaRoutingModule,
    MatSidenavModule,
    MatInputModule,
    MatIconModule,
    MatButtonModule,
    MatListModule,
    MatProgressBarModule,
    MatCardModule,
    MatToolbarModule,
    MatFormFieldModule,
    MatSelectModule,
    MatTableModule,
    ChartsModule,
    MatPaginatorModule,
    MatSortModule,
    MatDialogModule,
    MatSnackBarModule,
    MatCheckboxModule,
    MatChipsModule,
    CovalentFileModule,
    MatDatepickerModule,
    MatNativeDateModule,
    NgxMaterialTimepickerModule.forRoot(),
    MatStepperModule,
    MatExpansionModule,
    NgxMatSelectSearchModule,
    PickerModule
  ],
  declarations: [
    OverviewComponent,
    SocialMediaLinksComponent,
    PagesComponent,
    ThousandStuffSuffixesPipe,
    PostPerformaceComponent,
    FacebookPageOverviewComponent,
    DistrictMappingComponent,
    DialogContentFbDistrictMapComponent,
    NationalDistrictComponent,
    NationalDistrictListComponent,
    ApDistrictComponent,
    ApDistrictListComponent,
    SchedulerComponent,
    RecordsComponent,
    SelectedComponent,
    FilterComponent,
    FormComponent,
    DialogOverviewExampleDialogComponent,
    ScheduledPostsComponent,
    DialogSeePostDialogComponent,
    DialogLikeSourceComponent
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA, NO_ERRORS_SCHEMA],
  providers: [{ provide: LOCALE_ID, useValue: 'en-IN' }, MatNativeDateModule, ExcelService],
  entryComponents: [
    DialogContentFbDistrictMapComponent,
    DialogOverviewExampleDialogComponent,
    DialogSeePostDialogComponent,
    DialogLikeSourceComponent
  ]
})
export class SocialMediaModule { }
