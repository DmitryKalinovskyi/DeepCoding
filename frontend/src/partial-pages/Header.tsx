import React from "react";


function Header(){
    return (
        <header className="shadow-gray-300 shadow-sm">
            <div className="nav-bar flex justify-between container">
                <div className="nav-group">
                    <div>
                        <a href="/">
                            <img className="object-cover h-20" src="./logo.jpg"></img>
                        </a>
                    </div>
                    <div className="nav-link">
                        <a href="/problems">
                            Problems
                        </a>
                    </div>
                    <div className="nav-link">
                        <a href="/problems">
                            Competitions
                        </a>
                    </div>
                </div>
                <div className="nav-group">
                    <div className="nav-link">
                        <a href="/profile">
                            Profile
                        </a>
                    </div>
                </div>
            </div>
        </header>
    )
}

export default Header;

