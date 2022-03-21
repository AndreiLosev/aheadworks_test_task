import React from 'react';
import {useNavigate} from 'react-router-dom';
import { useForm } from "react-hook-form";
import {useDispatch, useSelector} from 'react-redux';
import {TiketActionCreater} from '../actions/tiketActions';
import {Spiner} from './Spiner';


export const TiketPage = () => {

    const state = useSelector(state => state);
    const { register, handleSubmit, formState: { errors } } = useForm();
    const [showSpiner, setShowSpiner] = React.useState(false);
    const dispatch = useDispatch();

    let navigate = useNavigate();

    React.useEffect(() => {
        navigate(state.auth.authToken ? '/tiket' : '/login');
    }, [state.auth.authToken])

    React.useEffect(() => {
        setShowSpiner(false);

        if (state.tiket.message !== '') {
            alert(state.tiket.message)
        }
    }, [state.tiket.message])

    const onSubmit = data => {
        setShowSpiner(true);
        dispatch(TiketActionCreater.thunkCreateNewTiket(data));
    }

    return <><form className='auth_form' onSubmit={handleSubmit(onSubmit)}>
        <div className='form_title'>Create new Tiket</div>
        <div className='form_fild'>
            <input
                type="text" className='form_input' placeholder='Tiket uid'
                {...register('uid', {required: 'This is requared'})}
            />
            <span className='error_message'>{errors.uid?.message}</span>
        </div>
        <div className='form_fild'>
            <input
                type="text" className='form_input' placeholder='Subject'
                {...register('subject', {required: 'This is requared'})}
            />
            <span className='error_message'>{errors.subject?.message}</span>
        </div>
        <div className='form_fild'>
            <input
                type="text" className='form_input' placeholder='User Name'
                {...register('user_name', {required: 'This is requared'})}
            />
            <span className='error_message'>{errors.user_name?.message}</span>
        </div>
        <div className='form_fild'>
            <input
                type="text" className='form_input' placeholder='User Email'
                {...register('user_email', {required: 'This is requared'})}
            />
            <span className='error_message'>{errors.user_email?.message}</span>
        </div>
        <div className='form_fild'>
            <textarea
                className='form_textarea' rows="3" placeholder="Message"
                {...register('message', {required: 'This is requared'})}
            />
            <span className='error_message'>{errors.message?.message}</span>
        </div>
        <div className='form_fild'>
            <input
                type="text" className='form_input' placeholder='ftp Login'
                {...register('ftp_login')}
            />
            <span className='error_message'>{errors.ftp_login?.message}</span>
        </div>
        <div className='form_fild'>
            <input
                type="passwrod" className='form_input' placeholder='ftp password'
                {...register('ftp_password')}
            />
            <span className='error_message'>{errors.ftp_password?.message}</span>
        </div>
        <div className='form_fild'>
            <input type="submit" value={'Create tiket'} className='form_submit' />
        </div>
    </form> <Spiner visible={showSpiner} /></>
}