import React from 'react';

import Header from '../components/Header'
import Footer from '../components/Footer'
import ProblemsFilter from "../components/ProblemsFilter";



function Problems(){
    return (
        <div>
            <Header/>
            <div className="container py-5" >
                <ProblemsFilter/>
            </div>
            <Footer/>
        </div>
    )
}


export default Problems;