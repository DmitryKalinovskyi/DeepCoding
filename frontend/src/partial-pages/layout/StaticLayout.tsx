import Header from "../Header.tsx";
import Footer from "../Footer.tsx";
import {cn} from "../../lib/utils.ts";

interface LayoutProps{
    haveHeader?: boolean,
    haveFooter?: boolean,
    children: JSX.Element[] | JSX.Element
}
export default function StaticLayout({haveHeader = true, haveFooter = true, children}: LayoutProps){
    function getHeightClassName(): string{
        if(haveFooter && haveHeader){
            return `h-[calc(100vh-var(--header-size)-var(--footer-size))]`;
        }
        else if(!haveFooter && haveHeader){
            return `h-[calc(100vh-var(--header-size))]`;
        }
        else if(!haveHeader && haveFooter){
            return `h-[calc(100vh-var(--footer-size))]`;
        }
        else{
            return "h-screen";
        }
    }

    return (
        <div className="min-h-screen flex flex-col">
            {haveHeader && <Header/>}
            <div className={cn("bg-gray-50", getHeightClassName())}>
                <div className="container h-full">
                    <div className="p-5 h-full">
                        {children}
                    </div>
                </div>
            </div>
            {haveFooter && <Footer/>}
        </div>
    )
}