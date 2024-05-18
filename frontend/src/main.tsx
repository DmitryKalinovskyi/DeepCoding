import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';

import {createBrowserRouter, RouterProvider} from "react-router-dom";
import Problems from "../../frontend/src/pages/Problems";
import Home from "../../frontend/src/pages/Home";
import Problem from "../../frontend/src/pages/Problem";

const root = ReactDOM.createRoot(
    document.getElementById('root') as HTMLElement
);

const router = createBrowserRouter([
    {
        path: "/problems",
        element: <Problems/>
    },
    {
        path: '/',
        element: <Home/>
    },
    {
        path: '/problem',
        element: <Problem Id={1}/>
    },
])

root.render(
    <React.StrictMode>
        <RouterProvider router={router}/>
    </React.StrictMode>
);

