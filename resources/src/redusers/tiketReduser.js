import {TiketActionsType} from '../actions/tiketActions';

const initState = {
    message: '',
};

export const tiketReduser = (state = initState, action) => {
    switch (action.type) {
        case TiketActionsType.SET_MESSAGE:
            return {...state, message: action.pyload};
        default:
            return state
    }
}