import {combineReducers} from 'redux';
import {authReduser} from './authReduser';
import {tiketReduser} from './tiketReduser';

export const rootReduser = combineReducers({
    auth: authReduser,
    tiket: tiketReduser,
});