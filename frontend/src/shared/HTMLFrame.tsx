import {useEffect, useRef} from "react";

interface NewsFrameProps{
    srcDoc?: string
}

export default function HTMLFrame(props: NewsFrameProps) {
    const ref = useRef<HTMLIFrameElement>(null);
    const resizeIFrame = (iframe: HTMLIFrameElement) => {
        if (iframe && iframe.contentWindow) {
            try {
                const contentHeight = iframe.contentWindow.document.documentElement.scrollHeight;
                iframe.style.height = `${contentHeight + 1}px`;
            } catch (error) {
                console.error("Error accessing iframe content:", error);
            }
        }
    };

    useEffect(() => {
        const iframe = ref.current;
        if (iframe) {
            const onLoadHandler = () => {
                setTimeout(() => resizeIFrame(iframe), 0);
            };

            const onResizeHandler = () => {
                resizeIFrame(iframe);
            };

            iframe.addEventListener("load", onLoadHandler);
            window.addEventListener("resize", onResizeHandler);

            return () => {
                iframe.removeEventListener("load", onLoadHandler);
                window.removeEventListener("resize", onResizeHandler);
            };
        }
    }, [props.srcDoc]);

    return (

    <iframe srcDoc={props.srcDoc}
            className="w-full overflow-visible"
            ref={ref}>
    </iframe>
        )
}