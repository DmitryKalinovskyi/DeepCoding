import useAuth from "../../hooks/useAuth.ts";
import {Navigate, Outlet} from "react-router-dom";

export default function RequireAuth(){
    const {auth} = useAuth();

    // if token is setted
    if(auth.accessToken === undefined){
        return (
            <Navigate to="/login" replace />
        )
    }

    return <Outlet/>
}