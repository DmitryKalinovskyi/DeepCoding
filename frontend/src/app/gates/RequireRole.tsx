import useAuth from "../../hooks/useAuth.ts";
import {Navigate, Outlet} from "react-router-dom";

interface RequireRoleProps{
    role: string
}

export default function RequireRole(props: RequireRoleProps){
    const {auth} = useAuth();

    // if token is setted
    if(auth.accessToken === undefined){
        return (
            <Navigate to="/login" replace />
        )
    }

    if(auth.roles.filter(r => props.role).length === 0){
        return (
            <Navigate to="/login" replace />
        )
    }

    return <Outlet/>
}