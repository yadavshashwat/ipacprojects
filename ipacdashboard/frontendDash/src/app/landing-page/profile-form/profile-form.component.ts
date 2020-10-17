/**
 * @author victor
 * Login form component
 */
import {
  Component,
  OnInit,
  Input,
  Output,
  EventEmitter
} from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  Validators,
  FormControl
} from '@angular/forms';
import { LoginService } from "../../services/login.service";
import { MatSnackBar } from '@angular/material';
import { Router } from '@angular/router';
import { Authenticate } from "../../interfaces/authentication/authenticate";

@Component({
  selector: 'app-profile-form',
  templateUrl: './profile-form.component.html',
  styleUrls: ['./profile-form.component.css']
})
export class ProfileFormComponent implements OnInit {

  ipacEmailPattern = '[a-zA-Z0-9]+\.[a-zA-Z0-9]+@indianpac\.com';

  @Input() error: string | null;

  @Input() set disabled(isDisabled: boolean) {
    if (isDisabled) {
      this.loginForm.disable();
    } else {
      this.loginForm.enable();
    }
  }

  @Output() submitted = new EventEmitter<Authenticate>();


  constructor() {
    this.loginForm.valueChanges
      .subscribe(data => this.onValueChanged(data));
    this.onValueChanged(); // (re)set validation messages now
  }

  loginForm = new FormGroup({
    email: new FormControl('', [
      Validators.required,
      Validators.pattern(this.ipacEmailPattern)
    ]),
    password: new FormControl('', [
      Validators.required
    ])
  });

  ngOnInit() {}

  onValueChanged(data?: any) {
    if (!this.loginForm) { return; }
    const form = this.loginForm;
    for (const field in this.loginFormErrors) {
      // clear previous error message (if any)
      this.loginFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.loginFormValidationMessages[field];
        for (const key in control.errors) {
          this.loginFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  loginFormErrors = {
    'email': '',
    'password': ''
  };
  loginFormValidationMessages = {
    'email': {
      'required': 'Email is required.',
      'pattern': 'Please use indianpac email'
    },
    'password': {
      'required': 'password is required.'
    }
  };


  onLoginSubmit() {
    // make a deep copy of the input items
    // console.log(this.loginForm.value);
    // const formModel = this.loginForm.value;
    // this._login.superAdminLogin(formModel.email, formModel.password).subscribe(
    //   (data) => {
    //     console.log('LOGIN DATA', data);
    //     if (data.result.auth) {
    //       // redirect to dashboard
    //       this._router.navigate(['/dashboards']);
    //     } else {
    //       // show snack bar
    //       this.snackBar.open(data.message, 'Close', {
    //         duration: 3000
    //       });
    //     }
    //   }
    // );

    const value: Authenticate = this.loginForm.value;
    if (this.loginForm.valid) {
      this.submitted.emit(value);
    }
  }

}
