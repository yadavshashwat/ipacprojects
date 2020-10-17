/**
 * @author victor
 * Module for media dashboard
 */
import {
  NgModule,
  CUSTOM_ELEMENTS_SCHEMA
} from '@angular/core';
import { CommonModule } from '@angular/common';
import { MediaRoutingModule } from './media-routing.module';
import { MediaViewComponent } from './media-view/media-view.component';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { MatIconModule } from '@angular/material/icon';
import { FormsModule } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule } from '@angular/forms';
import { MatSelectModule } from '@angular/material/select';
import { MatCardModule } from '@angular/material/card';
import { MatDividerModule } from '@angular/material/divider';
import { MatChipsModule } from '@angular/material/chips';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { MatListModule } from '@angular/material/list';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from "@angular/material";

import {
  AddNewsComponent,
  DialogAddAuthorComponent
} from './add-news/add-news.component';
import {
  MediaScanComponent,
  DialogContentAddNewsDialogComponent,
  DialogKeyComponent
} from './media-scan/media-scan.component';
import {
  KeywordsComponent,
  DialogContentKeyWordDialogComponent,
  DialogContentKeyWordEditDialogComponent
} from './keywords/keywords.component';
import {
  ScrapedNewsComponent,
  DialogContentScrapedNewsDialogComponent
} from './scraped-news/scraped-news.component';
import { AnalysisComponent } from './analysis/analysis.component';
import {
  PublicationComponent,
  DialogContentPublicationDialogComponent,
  DialogContentPublicationEditDialogComponent
} from './publication/publication.component';
import {
  AuthorComponent,
  DialogContentAuthorDialogComponent,
  DialogContentAuthorEditDialogComponent
} from './author/author.component';
import { UserComponent } from './user/user.component';
import { MatTableModule } from '@angular/material/table';
import { MatDialogModule, MatDialog } from '@angular/material/dialog';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MediaLinksComponent } from './media-links/media-links.component';
import { MatRadioModule } from '@angular/material/radio';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { NgxMatSelectSearchModule } from 'ngx-mat-select-search';
import { CategoryComponent, DialogAddCatComponent, DialogEditCatComponent } from './category/category.component';

@NgModule({
  imports: [
    CommonModule,
    MediaRoutingModule,
    MatSidenavModule,
    MatButtonModule,
    MatInputModule,
    MatIconModule,
    FormsModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    MatSelectModule,
    MatCardModule,
    MatDividerModule,
    MatChipsModule,
    MatAutocompleteModule,
    MatListModule,
    MatTableModule,
    MatDialogModule,
    MatSnackBarModule,
    MatSlideToggleModule,
    MatProgressBarModule,
    MatExpansionModule,
    MatPaginatorModule,
    MatRadioModule,
    MatCheckboxModule,
    MatToolbarModule,
    MatProgressSpinnerModule,
    NgxMatSelectSearchModule,
    MatDatepickerModule,
    MatNativeDateModule
  ],
  declarations: [
    MediaViewComponent,
    AddNewsComponent,
    MediaScanComponent,
    KeywordsComponent,
    ScrapedNewsComponent,
    AnalysisComponent,
    PublicationComponent,
    AuthorComponent,
    DialogContentAuthorDialogComponent,
    DialogContentAuthorEditDialogComponent,
    UserComponent,
    DialogContentKeyWordDialogComponent,
    DialogContentKeyWordEditDialogComponent,
    DialogContentPublicationDialogComponent,
    DialogContentPublicationEditDialogComponent,
    DialogContentAddNewsDialogComponent,
    DialogContentScrapedNewsDialogComponent,
    MediaLinksComponent,
    DialogAddAuthorComponent,
    CategoryComponent,
    DialogAddCatComponent,
    DialogEditCatComponent,
    DialogKeyComponent
  ],
  entryComponents: [
    DialogContentAuthorDialogComponent,
    DialogContentAuthorEditDialogComponent,
    DialogContentKeyWordDialogComponent,
    DialogContentKeyWordEditDialogComponent,
    DialogContentPublicationDialogComponent,
    DialogContentPublicationEditDialogComponent,
    DialogContentAddNewsDialogComponent,
    DialogContentScrapedNewsDialogComponent,
    DialogAddAuthorComponent,
    DialogAddCatComponent,
    DialogEditCatComponent,
    DialogKeyComponent
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  providers: []
})
export class MediaModule { }
