/**
 * @author victor
 * Login page component
 */
import {
  Component,
  OnInit
} from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  Validators
} from '@angular/forms';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { Login } from "../../actions/auth.actions";
import { Authenticate } from "../../interfaces/authentication/authenticate";


@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.css']
})
export class LandingPageComponent implements OnInit {

  title = 'I-PAC';

  error$ = this.store.select(fromStore.selectLoginPageError);
  pending$ = this.store.select(fromStore.selectLoginPagePending);

  constructor(
    private store: Store<fromStore.State>
  ) {}

  ngOnInit() { }

  onLogin(credentials: Authenticate) {
    this.store.dispatch(new Login(credentials));
  }

}
