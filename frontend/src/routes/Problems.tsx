import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';

import Header from '../components/Header'
import Footer from '../components/Footer'

const root = ReactDOM.createRoot(
    document.getElementById('root') as HTMLElement
);
root.render(
    <div className="Page">
        <Header />

        

        <Footer/>
    </div>
);
