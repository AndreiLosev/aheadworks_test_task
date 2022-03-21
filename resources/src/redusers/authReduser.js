import {AuthActionsType} from '../actions/authActions';
import Cookies from 'js-cookie'

const initState = {
    authToken: Cookies.get('aheadworks_test_task_token') ? Cookies.get('aheadworks_test_task_token') : null,
    error: null,
};

export const authReduser = (state=initState, action) => {
    switch (action.type) {
        case AuthActionsType.SET_QUERY_ERROR:
            return {...state, error: action.pyload};

        case AuthActionsType.SET_TOKEN:
            return {...state, authToken: action.pyload};

        default:
            return state
    }
}