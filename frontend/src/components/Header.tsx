import React from "react";


function Header(){
    return (
        <header className="p-3 mb-3 border-bottom">
            <div className="container">
                <div className="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul className="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li>
                            <a href="/">
                            <img className="App-logo" alt="logo" src="./logo.jpg" height={60}></img>
                            </a>
                        </li>
                        <li className="d-flex align-items-center">
                            <a href="/problems" className="nav-link px-2">
                                Problems
                            </a>
                        </li>
                    </ul>

                    <div className="dropdown text-end">
                        <a href="#" className="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul className="dropdown-menu text-small">
                            <li><a className="dropdown-item" href="/myprofile">Profile</a></li>
                            <li><hr className="dropdown-divider"></hr></li>
                            <li><a className="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    )
}

export default Header;

