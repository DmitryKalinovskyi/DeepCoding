import Select from "../components/Select.tsx";
import ReactCodeMirror from "@uiw/react-codemirror";
import {Button, ButtonBase} from "@mui/material";
import {useState} from "react";

function CodeEditor(){
    const [selectedCompiler, setSelectedCompiler] = useState("C++");

    function onCompilerSelect(e){
        setSelectedCompiler(e.target.value);
    }

    return (
        <div className="d-flex flex-column h-100">
            <div className="bg-light rounded-2">
                <div className="input-group mb-2">
                    <Select onChange={onCompilerSelect} value={selectedCompiler}>
                        <option >C++</option>
                        <option >C#</option>
                        <option >Python</option>
                    </Select>
                </div>
            </div>

                <ReactCodeMirror className="bg-black rounded-md mb-4" height="400px" theme="light"/>

            <Button variant="contained">Send</Button>
        </div>
    )
}

export default CodeEditor;