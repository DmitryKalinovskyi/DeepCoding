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
import Playground from "../../pages/playground/Playground.tsx";
import NewsPage from "../../pages/news/NewsPage.tsx";
import NewsEdit from "../../pages/news/NewsEdit.tsx";
import ProblemEdit from "../../pages/problems/ProblemEdit.tsx";
import Submission from "../../pages/submissions/Submission.tsx";

const router = createBrowserRouter([
    {
        element: <RequireAuth/>,
        children: [
            {
                path: "/profile/:userId", element: <Profile/>
            },
            {
                path: "/profile/:userId/edit", element: <ProfileEdit/>
            },
            {
                path: '/news/:newsId/edit', element: <NewsEdit/>
            },
            {
                path: '/problems/:problemId/edit', element: <ProblemEdit/>
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
        path: '/news/:newsId', element: <NewsPage/>
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
    {
        path: '/playground', element: <Playground/>
    },
    {
        path: '/submissions/:submissionId', element: <Submission/>
    }
])

export default function MyRouter(){
    return (
        <RouterProvider router={router}/>
    )
}