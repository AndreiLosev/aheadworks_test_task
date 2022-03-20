import React from 'react';
import {useSelector} from 'react-redux';
import {useNavigate} from 'react-router-dom';

export const TiketPage = () => {

    const authToken = useSelector(state => state.auth.authToken);
    let navigate = useNavigate();
    
    React.useEffect(() => {
        navigate(authToken ? '/tiket' : '/login');
    }, [authToken])

    return <div className='auth_form'>
        <div className='form_title'>Create new Tiket</div>
        <input type="text" className='form_input' placeholder='Tiket uid' />
        <input type="text" className='form_input' placeholder='Subject' />
        <input type="text" className='form_input' placeholder='User Name' />
        <input type="text" className='form_input' placeholder='User Email' />
        <textarea className='form_textarea' rows="3" placeholder="Message" />
        <input type="text" className='form_input' placeholder='ftp Login' />
        <input type="passwrod" className='form_input' placeholder='ftp password' />
        <input type="button" value={'Create tiket'} className='form_submit' />
    </div>
}