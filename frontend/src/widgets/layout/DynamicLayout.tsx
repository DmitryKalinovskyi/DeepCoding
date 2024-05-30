import Header from "../Header.tsx";
import Footer from "../Footer.tsx";

interface LayoutProps{
    children: JSX.Element[] | JSX.Element
}
export default function DynamicLayout(props: LayoutProps){
    return (
        <div className="min-h-screen flex flex-col">
            <Header/>
            <div className="flex-grow flex bg-gray-50">
                <div className="container">
                    <div className="p-5 min-h-full min-w-full">
                        {props.children}

                        </div>
                    </div>
            </div>
            <Footer/>
        </div>
    )
}