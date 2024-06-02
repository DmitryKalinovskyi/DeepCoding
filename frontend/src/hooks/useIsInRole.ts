import useAuth from "./useAuth.ts";

export default function useIsInRole(roleName: string){
    const {auth} = useAuth();
    if(auth.accessToken === undefined) return false;
    return auth.roles.filter(r => r.Name === roleName).length > 0;
}