/**
 * @author victor
 * Media Dashboard Module
 * Everything you see in media dashboard appears here
 */
import { NgModule } from '@angular/core';
import {
  Routes,
  RouterModule,
  CanActivate
} from '@angular/router';
import { MediaViewComponent } from "./media-view/media-view.component";
import { KeywordsComponent } from "./keywords/keywords.component";
import {
  ScrapedNewsComponent,
  DialogContentScrapedNewsDialogComponent
} from "./scraped-news/scraped-news.component";

import {
  MediaScanComponent,
  DialogContentAddNewsDialogComponent,
} from "./media-scan/media-scan.component";

import {
  PublicationComponent,
  DialogContentPublicationDialogComponent,
  DialogContentPublicationEditDialogComponent
} from "./publication/publication.component";

import {
  AuthorComponent,
  DialogContentAuthorDialogComponent,
  DialogContentAuthorEditDialogComponent
} from "./author/author.component";

import { AnalysisComponent } from "./analysis/analysis.component";
import { UserComponent } from "./user/user.component";
import { AuthGuardService } from "../services/auth-guard.service";
import { MediaAuthorizeGuardService } from "../services/media-authorize-guard.service";
import { CategoryComponent } from "./category/category.component";

const routes: Routes = [
  {
    path: 'add-news',
    component: MediaViewComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'keywords',
    component: KeywordsComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'scraped-news',
    component: ScrapedNewsComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'media-scan',
    component: MediaScanComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'publication-add',
    component: PublicationComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'author-add',
    component: AuthorComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'manage-user',
    component: UserComponent,
    canActivate: [AuthGuardService, MediaAuthorizeGuardService]
  },
  {
    path: 'analysis',
    component: AnalysisComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'category',
    component: CategoryComponent,
    canActivate: [AuthGuardService]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MediaRoutingModule { }
