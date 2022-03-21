import React from 'react';
import {Spiner} from './Spiner';
import { useForm } from "react-hook-form";
import {useDispatch, useSelector} from 'react-redux';
import {useNavigate} from 'react-router-dom';
import {AuthActionCreater} from '../actions/authActions';

export const LoginPage = () => {
    const { register, handleSubmit, formState: { errors } } = useForm();
    const [showSpiner, setShowSpiner] = React.useState(false);
    const dispatch = useDispatch();
    let navigate = useNavigate();
    const auth = useSelector(state => state.auth);

    React.useEffect(() => {
        setShowSpiner(false);
        navigate(auth.authToken ? '/tiket' : '/login');
    }, [auth.authToken])

    React.useEffect(() => {
        setShowSpiner(false);
    }, [auth.error]);

    const onSubmit = data => {
        setShowSpiner(true);
        dispatch(AuthActionCreater.thunkSingIn(data.login, data.passwrod));
    }

    return <>
        <form className='auth_form' onSubmit={handleSubmit(onSubmit)}>
            <div className='form_title'>Authorization</div>
            <div className='form_fild'>
                <input
                    type="text"
                    className='form_input'
                    placeholder='login'
                    {...register('login', {required: 'This is requared'})}
                />
                <span className='error_message'>{errors.login?.message}</span>
                <span className='error_message'>{auth?.error}</span>
            </div>
            <div className='form_fild'>
                <input
                    type="password"
                    className='form_input'
                    placeholder='password'
                    {...register('passwrod', {required: 'This is requared'})}
                />
                <span className='error_message'>{errors.passwrod?.message}</span>
                <span className='error_message'>{auth?.error}</span>
            </div>
            <div className='form_fild'>
                <input
                    type="submit"
                    value={'Sign in'}
                    className='form_submit'
                />
            </div>
        </form>
        <Spiner visible={showSpiner} />
    </>
}