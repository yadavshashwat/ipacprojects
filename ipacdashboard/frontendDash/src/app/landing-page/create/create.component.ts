/**
 * @author victor
 * Creating new password
 */
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MatSnackBar } from '@angular/material';
import { Router, ActivatedRoute } from '@angular/router';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.css']
})
export class CreateComponent implements OnInit {

  hide = true;

  passwordForm: FormGroup;
  secretString: string;

  constructor(
    private _fb: FormBuilder,
    private _snack: MatSnackBar,
    private route: ActivatedRoute,
    private router: Router,
    private _login: LoginService
  ) {
    this.route.params.subscribe((params) => {
      if (params.id) {
        this.secretString = params.id;
      }
    });
    this.buildForm();
  }

  buildForm() {
    this.passwordForm = this._fb.group({
      'password': ['', [Validators.required]],
      'confirm': ['', [Validators.required]],
    });
  }

  ngOnInit() {
  }

  changePassword() {
    const password = this.passwordForm.controls['password'].value;
    const confirm = this.passwordForm.controls['confirm'].value;
    if (password !== confirm) {
      this._snack.open('Passwords don\'t match', 'Close', {
        duration: 2000
      });
      return;
    }
    this._login.create(password, this.secretString).subscribe((data) => {
      if (!data) {
        this._snack.open('Error while creating the password', 'Close', {
          duration: 2000
        });
        return;
      }
      if (data.status) {
        this._snack.open(data.msg, 'Close', {
          duration: 1000
        });
      }
      this.router.navigate(['/']);
    });
  }

}
