import {createContext, useState} from "react";
import useLocalStorage from "../../hooks/useLocalStorage.ts";
import useSessionStorage from "../../hooks/useSessionStorage.ts";

export interface AuthContextType{
    auth: AuthType,
    setAuth: React.Dispatch<React.SetStateAction<object>>,
}

interface AuthType{
    accessToken?: string,
    roles?: [],
    userId?: number
}

const AuthContext = createContext<AuthContextType>({
    auth: {},
    setAuth: () => {}
})

interface AuthProviderProps{
    children: React.ReactElement[] | React.ReactElement
}

export function AuthProvider(props: AuthProviderProps){
    const [auth, setAuth] = useSessionStorage("__auth");
    return (
        <AuthContext.Provider value={{auth, setAuth}}>
            {props.children}
        </AuthContext.Provider>
    )
}

export default AuthContext;