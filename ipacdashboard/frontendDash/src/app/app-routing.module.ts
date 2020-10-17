import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuardService } from "./services/auth-guard.service";

const routes: Routes = [
    {
        path: 'dashboards/media',
        loadChildren: 'src/app/media/media.module#MediaModule'
    },
    {
        path: 'dashboards/social-media',
        loadChildren: 'src/app/social-media/social-media.module#SocialMediaModule'
    },
    {
        path: 'dashboards',
        loadChildren: 'src/app/dashboards/dashboards.module#DashboardsModule',
        canActivate: [AuthGuardService]
    },
    {
        path: '',
        loadChildren: 'src/app/landing-page/landing-page.module#LandingPageModule'
    },
    {
        path: '',
        redirectTo: '',
        pathMatch: 'full'
    }
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule { }
