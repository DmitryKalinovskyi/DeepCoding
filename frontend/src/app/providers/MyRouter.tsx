import {createBrowserRouter, RouterProvider} from "react-router-dom"
import Problems from "../../pages/problems/Problems.tsx";
import Problem from "../../pages/problems/Problem.tsx";
import Profile from "../../pages/profile/Profile.tsx";
import ProfileEdit from "../../pages/profile/edit/ProfileEdit.tsx";
import Home from "../../pages/home/Home.tsx";
import Competitions from "../../pages/competitions/Competitions.tsx";
import Dashboard from "../../pages/dashboard/Dashboard.tsx";
import Login from "../../pages/authentication/Login.tsx";
import Register from "../../pages/authentication/Register.tsx";
import RequireAuth from "../gates/RequireAuth.tsx";
import RequireRole from "../gates/RequireRole.tsx";

const router = createBrowserRouter([
    {
        element: <RequireAuth/>,
        children: [
            {
                path: "/profile", element: <Profile/>
            },
            {
                path: "/profile/edit", element: <ProfileEdit/>
            }
        ]
    },
    {
        path: "/problems", element: <Problems/>,
    },
    {
        path: '/problems/:problemId', element: <Problem/>
    },

    {
        path: '/', element: <Home/>
    },
    {
        path: '/competitions', element: <Competitions/>
    },
    {
        element: <RequireRole role={"Admin"}/>,
        children: [
            {
                path: '/dashboard', element: <Dashboard/>
            },
        ]
    },
    {
        path: '/login', element: <Login/>
    },
    {
        path: '/register', element: <Register/>
    },
])

export default function MyRouter(){
    return (
        <RouterProvider router={router}/>
    )
}