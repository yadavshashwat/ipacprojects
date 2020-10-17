/**
 * @author victor
 */
import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {JoinPkService} from '../../join-pk.service';
import {MatSnackBar} from '@angular/material';
import {Router} from '@angular/router';
import {AuthService} from '../../auth.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  hide = true;
  loginForm: FormGroup;

  constructor(
    private _fb: FormBuilder,
    private _login: JoinPkService,
    private _snack: MatSnackBar,
    private _router: Router,
    private _auth: AuthService
  ) {

  }

  ngOnInit() {
    this.loginForm = this._fb.group({
      user: ['', [Validators.required]],
      password: ['', [Validators.required]]
    });
  }

  onLoginSubmit() {
    const value = this.loginForm.value;
    const payload = {
      user: value.user,
      password: value.password
    };
    this.loginForm.disable();
    this._login.login(payload).subscribe((response) => {
      if (response.status) {
        // navigate to dashboard page
        this._auth.sendToken(payload.user);
        this._router.navigate(['/dashboard']);
      } else {
        // enable the page
        this.loginForm.enable();
        this._snack.open(response.status_message, 'close', {
          duration: 2000
        });
      }
    });
  }

}
