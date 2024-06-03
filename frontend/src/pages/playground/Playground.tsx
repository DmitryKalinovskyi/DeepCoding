import Card from "@mui/material/Card";
import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import {useState} from "react";
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import StorageIcon from '@mui/icons-material/Storage';
import {Button, CircularProgress, TextField, Typography} from "@mui/material";
import axios from "../../api/axios.ts";
import CodeEditor from "../../shared/CodeEditor.tsx";

export default function Playground(){
    const [code, setCode] = useState("");
    const [fetching, setFetching] = useState(false);
    const [codeResult, setCodeResult] = useState({
        Output: "",
        RunningTime: 0,
        MemoryUsed: 0
    });
    async function run(){
        // console.log("Code: " + code)
        setFetching(true);

        const response = await axios.post("/api/coderunner/run", {
            code,
            compiler: "Python3"
        });

        console.log(response.data);
        setCodeResult(response.data);
        setFetching(false);
    }

    return (
        <StaticLayout>
            <div className="flex h-full items-stretch gap-4">
                <Card className="basis-1/2 p-4">

                    <div className="overflow-y-auto">

                    {/*<TextField name="code"*/}
                    {/*           fullWidth*/}
                    {/*           multiline*/}
                    {/*           onChange={(e) => setCode(e.target.value)}*/}
                    {/*           rows={10}*/}
                    {/*           className="pb-4"*/}
                    {/*           placeholder={"Enter code.."}*/}

                    {/*/>*/}
                    <CodeEditor onChange={(value) => setCode(value)}/>
                    </div>
                    <Button onClick={run} variant="contained">Run</Button>
                </Card>
                <Card className="basis-1/2 p-4 ">
                    {fetching ? <div className="flex flex-col justify-center items-center h-full">
                            <CircularProgress/>
                            <div>Running</div>
                        </div> :
                        <div className="h-full overflow-y-auto">
                            <div className="flex gap-4 items-center mb-4">
                                <div className="font-sans font-semibold">
                                    Completed
                                </div>
                                <div className="flex items-center gap-1">
                                    <AccessTimeIcon/>
                                    <span className="font-sans font-semibold">
                                        {codeResult.RunningTime} ms
                                    </span>
                                </div>
                                <div className="flex items-center gap-1">
                                        <StorageIcon/>
                                    <span className="font-sans font-semibold">
                                        {codeResult.MemoryUsed} mb
                                    </span>
                                </div>
                            </div>
                            <Typography component="div"
                                        className="bg-gray-100 p-4 border rounded-md">
                                <pre style={{fontFamily: 'Roboto Mono, monospace', margin: 0}}>
                                    {codeResult.Output}
                                </pre>
                            </Typography>
                        </div>
                        // <div className="h-full overflow-y-auto">
                        // <Typography>
                        //     <pre>
                        //         {codeResult.Output}
                        //     </pre>
                        // </Typography>
                        // </div>
                    }
                </Card>
            </div>
        </StaticLayout>
    )
}