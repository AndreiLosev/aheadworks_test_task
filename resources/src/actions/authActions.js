import {sendRequest} from '../api/index';
import Cookies from 'js-cookie'

export class AuthActionsType {
    static SET_QUERY_ERROR = 'AuthActionsType/SET_QUERY_ERROR';
    static SET_TOKEN = 'AuthActionsType/SET_TOKEN';
}

export class AuthActionCreater {

    static setQueryError = (errorMessage) => ({
        type: AuthActionsType.SET_QUERY_ERROR,
        pyload: errorMessage
    })

    static setToken = (token) => ({
        type: AuthActionsType.SET_TOKEN,
        pyload: token,
    })


    static thunkSingIn = (login, password) => async dispatch => {
        const response = await sendRequest('login', {login, password});

        if (response.status !== 200) {
            dispatch(AuthActionCreater.setQueryError('invalid login or password'));
            return;
        }

        const result = await response.json();
        Cookies.set('aheadworks_test_task_token', result['x-auth-token']);
        dispatch(AuthActionCreater.setToken(result['x-auth-token']));
        dispatch(AuthActionCreater.setQueryError(null));
    }
}