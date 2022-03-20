import React from 'react';
import {Spiner} from './Spiner';

export const LoginPage = () => {

    return <>
        <div className='auth_form'>
            <div className='form_title'>Authorization</div>
            <input type="text" className='form_input' placeholder='login' />
            <input type="password" className='form_input' placeholder='password' />
            <input
                type="button"
                value={'Sign in'}
                className='form_submit'
            />
        </div>
        <Spiner visible={false} />
    </>
}