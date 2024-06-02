import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import Card from "@mui/material/Card";
import Input from "../../shared/Input.tsx";
import {Alert, Button, CircularProgress, TextField} from "@mui/material";
import {Link, useNavigate} from "react-router-dom";
import {useRef, useState} from "react";
import axios from "../../api/axios.ts";
import useAuth from "../../hooks/useAuth.ts";

export default function Login(){
    const loginRef = useRef();
    const passwordRef = useRef();
    const [loginError, setLoginError] = useState(false);
    const [passwordError, setPasswordError] = useState(false);
    const [login, setLogin] = useState("");
    const [password, setPassword] = useState("");
    const [postError, setPostError] = useState("");

    const [isFetching, setIsFetching] = useState(false);
    const { setAuth} = useAuth();
    const navigate = useNavigate();

    function validatePassword(){
        return true;
        // return password.length >= 5;
    }

    function validateLogin(){
        return login.length >= 4;
    }

    async function onSubmit(e){
        e.preventDefault();
        setPostError("");

        console.log("submited.")
        if(!validateLogin() || !validatePassword()){
            setPasswordError(!validatePassword());
            setLoginError(!validateLogin());
            return;
        }

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());


        // try to log in
        try{
            setIsFetching(true);
            const response = await axios.post('/api/authenticate', data);
            setIsFetching(false);

            console.log(response.data);
            setAuth(response.data);
            navigate("/");
        }
        catch(err: any){
            setIsFetching(false);
            if(err.response)
            setPostError(err.response.data.errors.toString())
        }
    }

    return (
        <StaticLayout>
            <div className="flex items-center justify-center h-full">
                <Card className="p-4 w-96 ">
                    <form onSubmit={onSubmit} method="post">
                        <div className="font-semibold text-2xl text-center mb-8">
                            Login
                        </div>
                        <TextField ref={loginRef}
                                   className="w-full mb-4"
                                   label="Login"
                                   name="Login"
                                   variant="outlined"
                                   autoComplete="off"
                                   error={loginError}
                                   onBlur={() => setLoginError(!validateLogin())}
                                   onChange={(e) => setLogin(e.target.value)}
                                   helperText={loginError? "Login should contain at least 4 characters" : ""}
                        />
                        <TextField ref={passwordRef}
                                   className="w-full mb-4"
                                   label="Password"
                                   name="Password"
                                   type="password"
                                   variant="outlined"
                                   error={passwordError}
                                   onBlur={() => setPasswordError(!validatePassword())}
                                   onChange={(e) => setPassword(e.target.value)}
                                   helperText={passwordError? "Password should have least 5 characters" : ""}
                        />
                        {isFetching && <div className="flex justify-center items-center mb-4"><CircularProgress /></div>}
                        {postError !== "" &&
                            <Alert severity="error" className="mb-4">{postError}</Alert>}
                        <Button className="w-full mb-2" variant="contained" type="submit">Login</Button>
                        <div className="text-center">
                            Don't have account?
                            <Link to="/register" className="text-blue-500"> Register</Link>
                        </div>
                    </form>
                </Card>
            </div>
        </StaticLayout>
    )
}