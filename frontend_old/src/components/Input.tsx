
interface InputProps{
    name?: string,
    options?: [],
    children?: React.ReactNode
}

export default function Input(props: InputProps ){
    console.log(props)
    return <>
        <select className="shadow-sm outline-0 border-2 rounded">

        </select>
    </>
}