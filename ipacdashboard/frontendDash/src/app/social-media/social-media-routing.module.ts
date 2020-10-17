import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuardService } from "../services/auth-guard.service";
import { OverviewComponent } from "./overview/overview.component";
import { PagesComponent } from "./pages/pages.component";
import { PostPerformaceComponent } from "./post-performace/post-performace.component";
import { FacebookPageOverviewComponent } from "./facebook-page-overview/facebook-page-overview.component";
import { DistrictMappingComponent } from "./district-mapping/district-mapping.component";

// National district pages
import { NationalDistrictListComponent } from "./national-district-list/national-district-list.component";
import { NationalDistrictComponent } from "./national-district/national-district.component";

// AP district pages
import { ApDistrictListComponent } from "./ap-district-list/ap-district-list.component";
import { ApDistrictComponent } from "./ap-district/ap-district.component";

// Scheduler component
import { SchedulerComponent } from "./scheduler/scheduler.component";
import { ScheduledPostsComponent } from "./scheduled-posts/scheduled-posts.component";

const routes: Routes = [
  {
    path: 'page-performance',
    component: OverviewComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'page-performance/:id',
    component: PagesComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'national-district',
    component: NationalDistrictListComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'national-district/:id',
    component: NationalDistrictComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'ap-district',
    component: ApDistrictListComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'ap-district/:id',
    component: ApDistrictComponent,
    canActivate: [AuthGuardService]
  },
  // {
  //   path: 'post-performance',
  //   component: PostPerformaceComponent,
  //   canActivate: [AuthGuardService]
  // },
  {
    path: 'overview',
    component: FacebookPageOverviewComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'district-mapping',
    component: DistrictMappingComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'scheduler',
    component: SchedulerComponent,
    canActivate: [AuthGuardService]
  },
  {
    path: 'scheduled-posts',
    component: ScheduledPostsComponent,
    canActivate: [AuthGuardService]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SocialMediaRoutingModule { }
