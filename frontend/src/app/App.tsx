import MyRouter from "./providers/MyRouter.tsx";
import {AuthProvider} from "./providers/AuthContext.tsx";


export default function App(){
    return (
        <AuthProvider>
            <MyRouter/>
        </AuthProvider>
        )
}