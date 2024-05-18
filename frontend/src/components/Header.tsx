import React from "react";


function Header(){
    return (
        <header className="container shadow-gray-300 shadow-sm">
            <ul className="flex items-center">
                <li>
                    <a href="/">
                        <img className="object-cover h-20" src="./logo.jpg"></img>
                    </a>
                </li>
                <li>
                    <a href="/problems" className="px-2">
                        Problems
                    </a>
                </li>
                <li>
                    <a href="/competitions" className="px-2">
                        Competitions
                    </a>
                </li>
            </ul>
        </header>
    )
}

export default Header;

