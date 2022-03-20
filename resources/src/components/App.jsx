import React from 'react'
import {createStore, applyMiddleware} from 'redux'
import {Provider} from 'react-redux'
import {rootReduser} from '../redusers/index';
import thunk from 'redux-thunk';
import {BrowserRouter, Route, Routes, Navigate} from 'react-router-dom';
import {LoginPage} from './LoginPage';
import {TiketPage} from './TiketPage';
import './app.css';



const store = createStore(rootReduser, applyMiddleware(thunk))

export const App = () => {
    return (
        <Provider store={store}>
            <BrowserRouter>
                <Routes>
                    <Route path='/login' element={<LoginPage />} />
                    <Route path='/tiket' element={<TiketPage />} />
                    <Route
                        path="*"
                        element={<Navigate to="/login" replace />}
                    />
                </Routes>
            </BrowserRouter>
        </Provider>
    );

}