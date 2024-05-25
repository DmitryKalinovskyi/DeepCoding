function Header(){
    return (
        <header className="z-20 shadow-gray-300 shadow-sm h-header">
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
                        <a href="/competitions">
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
                    <div className="nav-link">
                        <a href="/dashboard">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>
    )
}

export default Header;

