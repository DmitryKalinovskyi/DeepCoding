import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import Card from "@mui/material/Card";
import {Alert, Button, CircularProgress, TextField} from "@mui/material";
import {Link} from "react-router-dom";
import axios from '../../api/axios.ts'
import {useEffect, useRef, useState} from "react";

export default function Register(){

    const loginRef = useRef();
    const nameRef = useRef();
    const passwordRef = useRef();
    const repeatPassRef = useRef();

    const [login, setLogin] = useState("");
    const [name, setName] = useState("");
    const [password, setPassword] = useState("");
    const [repeatPwd, setRepeatPwd] = useState("");

    const [loginError, setLoginError] = useState(false);
    const [nameError, setNameError] = useState(false);
    const [passwordError, setPasswordError] = useState(false);
    const [repeatPwdError, setRepeatPwdError] = useState(false);

    const [postError, setPostError] = useState("");
    const [isFetching, setIsFetching] = useState(false);

    useEffect(() => {
         if(loginRef.current)
         loginRef.current.focus();
    }, []);

    function validateLogin(){
        return login.length >= 4;
    }

    function validateName(){
        return name.length >= 4
    }

    function validatePassword(){
        return password.length >= 5;
    }

    function validatePasswordRepeat(){
        return password === repeatPwd;
    }

    async function onSubmit(e){
        e.preventDefault();
        setPostError("");

        if(!validateLogin() || !validateName() || !validatePasswordRepeat() || !validatePasswordRepeat()){
            setLoginError(!validateLogin());
            setNameError(!validateName());
            setPasswordError(!validatePasswordRepeat());
            setRepeatPwdError(!validatePasswordRepeat());
            return;
        }

        const data = new FormData(e.target);
        const obj = Object.fromEntries(data.entries());

        try{
            setIsFetching(true);
            const response = await axios.post("api/users/register",
                JSON.stringify(obj))
            setIsFetching(false);

            window.location.pathname = "/login";

        }catch(err){
            setIsFetching(false);
            if(err.response.status === 422){
                console.log("validation failed");
                setPostError(err.response.data.errors.toString())
                // setPostError(err.response.data.error.toString());
            }
            else{
                console.log(err.message);
            }
        }
    }

    return (
        <StaticLayout>
            <div className="flex items-center justify-center h-full">
                <Card className="p-4 w-96 ">
                    <form onSubmit={onSubmit}>
                        <div className="font-semibold text-2xl text-center mb-8">
                            Register
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

                        <TextField ref={nameRef}
                                   className="w-full mb-4"
                                   name="Name"
                                   autoComplete="off"
                                   label="Name"
                                   variant="outlined"
                                   error={nameError}
                                   onBlur={() => setNameError(!validateName())}
                                   onChange={(e) => setName(e.target.value)}
                                   helperText={nameError? "Name should contain at least 4 characters" : ""}
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

                        <TextField ref={repeatPassRef}
                                   className="w-full mb-4"
                                   label="Repeat Password"
                                   type="password"
                                   variant="outlined"
                                   error={repeatPwdError}
                                   onBlur={() => setRepeatPwdError(!validatePasswordRepeat())}
                                   onChange={(e) => setRepeatPwd(e.target.value)}
                                   helperText={repeatPwdError? "Password don't match" : ""}
                        />
                        {isFetching && <div className="flex justify-center items-center mb-4"><CircularProgress /></div>}

                        {postError !== "" &&
                        <Alert severity="error" className="mb-4">{postError}</Alert>}
                        <Button className="w-full mb-2"
                                variant="contained"
                                type="submit"
                        >Register</Button>
                        <div className="text-center">
                            Have account?
                            <Link to="/login" className="text-blue-500"> Login</Link>
                        </div>
                    </form>
                </Card>
            </div>
        </StaticLayout>
    )
}