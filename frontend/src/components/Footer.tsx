import React from "react";

function Footer(){
    return (
        <footer
            className="footer d-flex flex-wrap mt-5 justify-content-between align-items-center py-3 bg-body-tertiary">
            <div className="container">
                <div className="col-md-4 d-flex align-items-center">
                    <span className="mb-3 mb-md-0 text-body-secondary">© 2024 Dmytro Kalinovskyi</span>
                    <div className="vr mx-2"></div>
                    <div><a href="//viewsiews/info.php">info page</a></div>
                </div>
            </div>
        </footer>
    )
}

export default Footer;

