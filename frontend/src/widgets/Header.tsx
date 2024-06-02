import {Link} from "react-router-dom";
import logo from "/logo.jpg";
import useIsAuthenticated from "../hooks/useIsAuthenticated.ts";
import useIsInRole from "../hooks/useIsInRole.ts";
import useAuth from "../hooks/useAuth.ts";
import { ButtonBase } from "@mui/material";

function Header(){
    const {setAuth} = useAuth();
    const isAuthenticated = useIsAuthenticated();
    const isAdmin = useIsInRole("Admin");

    return (
        <header className="z-20 shadow-gray-300 shadow-sm h-header">
            <div className="nav-bar flex justify-between container">
                <div className="nav-group">
                    <div>
                        <Link to="/">
                            <img className="object-cover h-20" src={logo}></img>
                        </Link>
                    </div>
                    <div className="nav-link">
                        <Link to="/problems">
                            Problems
                        </Link>
                    </div>
                    <div className="nav-link">
                        <Link to="/competitions">
                            Competitions
                        </Link>
                    </div>
                </div>
                <div className="nav-group">
                    {isAuthenticated &&
                        <>
                            <div className="nav-link">
                                <Link to="/profile">
                                    Profile
                                </Link>
                            </div>
                            <div className="nav-link">
                                <button onClick={() => setAuth({})} >Log out</button>
                            </div>
                        </>
                    }

                    {isAdmin &&
                        <div className="nav-link">
                            <Link to="/dashboard">
                                Dashboard
                        </Link>
                    </div>}

                    {!isAuthenticated &&
                        <>
                        <div className="nav-link">
                            <Link to="/login">
                                Login
                            </Link>
                        </div>
                        <div className="nav-link">
                            <Link to="/register">
                                Register
                            </Link>
                        </div>
                        </>
                    }
                </div>
            </div>
        </header>
    )
}

export default Header;

