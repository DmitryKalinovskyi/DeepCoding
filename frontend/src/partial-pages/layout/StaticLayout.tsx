import Header from "../Header.tsx";
import Footer from "../Footer.tsx";

interface LayoutProps{
    children: JSX.Element[] | JSX.Element
}
export default function StaticLayout(props: LayoutProps){
    return (
        <div className="min-h-screen flex flex-col">
            <Header/>
            <div className="h-[calc(100vh-80px-40px)] bg-gray-50">
                <div className="container h-full">
                    <div className="p-5 h-full">
                        {props.children}
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    )
}