import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from "@angular/forms";
import { LandingPageRoutingModule } from './landing-page-routing.module';
import { LandingPageComponent } from './landing-page/landing-page.component';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatInputModule } from '@angular/material/input';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { ProfileFormComponent } from './profile-form/profile-form.component';
import { AuthEffects } from "../effects/auth.effects";
import { EffectsModule } from '@ngrx/effects';
import { ForgotComponent } from './forgot/forgot.component';
import { ErrorStateMatcher, ShowOnDirtyErrorStateMatcher } from '@angular/material/core';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { CreateComponent } from './create/create.component';


@NgModule({
  imports: [
    CommonModule,
    LandingPageRoutingModule,
    MatButtonModule,
    MatCardModule,
    MatInputModule,
    FormsModule,
    ReactiveFormsModule,
    MatSnackBarModule,
    EffectsModule.forFeature([AuthEffects]),
    MatFormFieldModule,
    MatIconModule
  ],
  declarations: [LandingPageComponent, ProfileFormComponent, ForgotComponent, CreateComponent],
  providers: [
    { provide: ErrorStateMatcher, useClass: ShowOnDirtyErrorStateMatcher }
  ]
})
export class LandingPageModule { }
