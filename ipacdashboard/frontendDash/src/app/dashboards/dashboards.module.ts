import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardsRoutingModule } from './dashboards-routing.module';
import { DashnoardsViewComponent } from './dashnoards-view/dashnoards-view.component';
import { ToolbarComponent } from '../toolbar/toolbar.component';

import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { UserManageComponent, DialogUserComponent } from './user-manage/user-manage.component';
import { MatDialogModule } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule } from '@angular/forms';
import { MatInputModule } from '@angular/material/input';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatTableModule } from '@angular/material/table';
import { MatProgressBarModule } from '@angular/material';
import { MatPaginatorModule, MatSortModule } from '@angular/material';





@NgModule({
  imports: [
    CommonModule,
    DashboardsRoutingModule,
    MatCardModule,
    MatButtonModule,
    MatToolbarModule,
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    MatDialogModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    MatInputModule,
    MatCheckboxModule,
    MatSnackBarModule,
    MatTableModule,
    MatProgressBarModule,
    MatPaginatorModule,
    MatSortModule
  ],
  declarations: [
    DashnoardsViewComponent,
    ToolbarComponent,
    UserManageComponent,
    DialogUserComponent
  ],
  entryComponents: [
    DialogUserComponent
  ]
})
export class DashboardsModule { }
