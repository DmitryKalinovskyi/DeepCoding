import {Link} from "react-router-dom";
import logo from "/logo.jpg";

function Header(){
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
                    {/*if is logged in*/}
                    <div className="nav-link">
                        <Link to="/profile">
                            Profile
                        </Link>
                    </div>

                    {/*if is admin*/}
                    <div className="nav-link">
                        <Link to="/dashboard">
                            Dashboard
                        </Link>
                    </div>

                    {/*if is not logged in*/}
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
                </div>
            </div>
        </header>
    )
}

export default Header;

