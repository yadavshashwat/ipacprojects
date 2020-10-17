/**
 * @author victor
 */
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormControl, FormGroupDirective, NgForm, Validators } from '@angular/forms';
import { ErrorStateMatcher } from '@angular/material/core';
import { MatSnackBar } from '@angular/material';
import { LoginService } from '../../services/login.service';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}

@Component({
  selector: 'app-forgot',
  templateUrl: './forgot.component.html',
  styleUrls: ['./forgot.component.css']
})
export class ForgotComponent implements OnInit {

  ipacEmailPattern = '[a-zA-Z0-9]+\.[a-zA-Z0-9]+@indianpac\.com';

  emailFormControl = new FormControl('', [
    Validators.required,
    Validators.pattern(this.ipacEmailPattern),
  ]);

  matcher = new MyErrorStateMatcher();

  constructor(
    private _snack: MatSnackBar,
    private _login: LoginService,
    private _router: Router
  ) { }

  ngOnInit() {
  }

  sendEmail() {
    this._snack.open('Please wait sending email', 'Close', {
      duration: 1000
    });
    this._login.forgot(this.emailFormControl.value).subscribe((data) => {
      if (!data) {
        this._snack.open('Error while sending email', 'Close', {
          duration: 1000
        });
      }
      if (data.status) {
        this._snack.open(data.message, 'Close', {
          duration: 1000
        });
      }
      this._router.navigate(['/']);
    });
  }

}
