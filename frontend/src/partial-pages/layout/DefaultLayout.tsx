import Header from "../Header.tsx";
import Footer from "../Footer.tsx";

interface LayoutProps{
    children: JSX.Element[] | JSX.Element
}
export function DefaultLayout(props: LayoutProps){
    return (
        <div className="min-h-screen flex flex-col">
            <Header/>
            <div className="container p-5 flex-grow">
                {props.children}
            </div>
            <Footer/>
        </div>
    )
}