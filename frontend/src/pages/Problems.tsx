import React from 'react';

import Header from '../partial-pages/Header'
import Footer from '../partial-pages/Footer'
import ProblemsFilter from "../partial-pages/SearchFilter.tsx";



function Problems(){
    return (
        <>
            <Header/>
                <div className="container py-5" >
                    <ProblemsFilter/>
                </div>
            <Footer/>
        </>
    )
}


export default Problems;