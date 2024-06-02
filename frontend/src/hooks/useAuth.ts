import {useContext} from "react";
import AuthContext, {AuthContextType} from "../app/providers/AuthContext.tsx";

export default function useAuth(){
    return useContext<AuthContextType>(AuthContext);
}