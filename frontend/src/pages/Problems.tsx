import React from 'react';

import Header from '../partial-pages/Header'
import Footer from '../partial-pages/Footer'
import ProblemsFilter from "../partial-pages/SearchFilter.tsx";
import {DefaultLayout} from "../partial-pages/layout/DefaultLayout.tsx";



function Problems(){
    return (
        <DefaultLayout>
            <ProblemsFilter pageSize={25}/>
        </DefaultLayout>
    )
}


export default Problems;