/**
 * @author Victor
 * Action for the Authentication
 */
import { Action } from '@ngrx/store';
import {
  AuthActions,
  AuthActionTypes
} from "../actions/auth.actions";
import { UserResponse } from "../interfaces/media-dashboard/user-response";


export interface State {
  user: UserResponse | null;
}

export const initialState: State = {
  user: null
};

export function reducer(state = initialState, action: AuthActions): State {
  switch (action.type) {

    case AuthActionTypes.LoginSuccess:
      return { ...state, user: action.payload.user };

    case AuthActionTypes.LogoutConfirmed:
      return initialState;

    default:
      return state;
  }
}

export const selectUser = (state: State) => state.user;
