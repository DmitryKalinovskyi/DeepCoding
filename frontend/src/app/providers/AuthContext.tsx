import {useContext, useState} from "react";

const AuthContext = React.createContext();

interface AuthProviderProps{
    children: React.ReactElement[]
}

export function useAuth(){
    return useContext(AuthContext);
}

export function AuthProvider(props: AuthProviderProps){
    const [authUser, setAuthUser] = useState(null);
    const [isLoggedIn, setIsLoggedIn] = useState(false);



}