import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';

import {createBrowserRouter, RouterProvider} from "react-router-dom";
import Problems from "./pages/problems/Problems.tsx";
import Home from "./pages/home/Home.tsx";
import Problem from "./pages/problems/Problem.tsx";
import Competitions from "./pages/competitions/Competitions.tsx";
import Dashboard from "./pages/dashboard/Dashboard.tsx";
import Profile from "./pages/profile/Profile.tsx";

const root = ReactDOM.createRoot(
    document.getElementById('root') as HTMLElement
);

const router = createBrowserRouter([
    {
        path: "/problems",
        element: <Problems/>
    },
    {
        path: "/profile",
        element: <Profile/>
    },
    {
        path: '/',
        element: <Home/>
    },
    {
        path: '/problem',
        element: <Problem id={3}/>
    },
    {
        path: '/competitions',
        element: <Competitions/>
    },
    {
        path: '/dashboard',
        element: <Dashboard/>
    },
])

root.render(
    <React.StrictMode>
        <RouterProvider router={router}/>
    </React.StrictMode>
);

