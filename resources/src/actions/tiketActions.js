import {sendRequest} from '../api/index';

export class TiketActionsType {
    static SET_MESSAGE = 'TiketActionsType/SET_MESSAGE';
}


export class TiketActionCreater {
    static setMessage = mess => ({
        type: TiketActionsType.SET_MESSAGE,
        pyload: mess,
    })

    static thunkCreateNewTiket = ({uid, subject, user_name, user_email, message, ftp_login, ftp_password}) => async (dispatch, getState) => {
        const response = await sendRequest('tiket/create', {
            uid, subject, user_name, user_email, message, ftp_login, ftp_password,
        }, getState().auth.authToken);

        const result = await response.json();

        if (response.status === 500) {
            dispatch(TiketActionCreater.setMessage(result['errorMessage']));
            return;
        }

        if (response.status === 400) {
            dispatch(TiketActionCreater.setMessage(` <<< this uid already exists >>> \n ${result['errorMessage']}`));
            return;
        }

        if (response.status >= 400) {
            dispatch(TiketActionCreater.setMessage(JSON.stringify(result, null, 2)));
            return
        }

        dispatch(TiketActionCreater.setMessage('Sucsses !!!'))
    }
}