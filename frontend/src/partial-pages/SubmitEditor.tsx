import Select from "../components/Select.tsx";
import ReactCodeMirror from "@uiw/react-codemirror";
import {Button, ButtonBase} from "@mui/material";
import {useState} from "react";
import CodeEditor from "../components/CodeEditor.tsx";

// code editor is custom component for displaying code inside application.

function SubmitEditor(){
    const [selectedCompiler, setSelectedCompiler] = useState("C++");

    function onCompilerSelect(e){
        setSelectedCompiler(e.target.value);
    }

    return (
        <div className="flex flex-col h-full">
            <div className="bg-light rounded-2">
                <div className="input-group mb-2">
                    <Select onChange={onCompilerSelect} value={selectedCompiler}>
                        <option >C++</option>
                        <option >C#</option>
                        <option >Python</option>
                    </Select>
                </div>
            </div>
            <CodeEditor className="flex-grow overflow-auto"/>
            <Button className="mt-4 w-20 bg-violet-700"
                    variant="contained">Send</Button>
        </div>
    )
}

export default SubmitEditor;