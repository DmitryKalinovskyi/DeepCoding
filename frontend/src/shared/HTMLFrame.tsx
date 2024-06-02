
interface NewsFrameProps{
    srcDoc?: string
}

export default function HTMLFrame(props: NewsFrameProps) {
    async function resizeIFrame(obj){
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }

    return (

    <iframe srcDoc={props.srcDoc}
            className="w-full"
            onLoad={(e) => resizeIFrame(e.target)}>
    </iframe>
        )
}