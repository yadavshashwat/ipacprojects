/**
 * @author victor
 * Routing module for dashboards module
 */
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DashnoardsViewComponent } from './dashnoards-view/dashnoards-view.component';
import { UserManageComponent } from './user-manage/user-manage.component';

const routes: Routes = [
  {
    path: 'list',
    component: DashnoardsViewComponent
  },
  {
    path: 'privilege',
    component: UserManageComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardsRoutingModule { }
