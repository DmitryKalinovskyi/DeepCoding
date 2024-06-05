import Card from "@mui/material/Card";
import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import {useState} from "react";
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import StorageIcon from '@mui/icons-material/Storage';
import {Button, CircularProgress, TextField, Typography} from "@mui/material";
import axios from "../../api/axios.ts";
import CodeEditor from "../../shared/CodeEditor.tsx";
import {TabControl, TabPanel} from "../../shared/TabControl.tsx";

export default function Playground(){
    const [code, setCode] = useState("");
    const [fetching, setFetching] = useState(false);
    const [codeResult, setCodeResult] = useState({
        output: "",
        runningTime: 0,
        memoryUsed: 0,
        notExecuted: true
    });
    const [input, setInput] = useState("");

    const [page, setPage] = useState(0);

    async function run(){
         console.log("Code: " + code)
        setFetching(true);
         setPage(1);
        try{

            const response = await axios.post("/api/coderunner/run", {
                code,
                compiler: "Python3",
                input
            });

            console.log(response.data);
            setCodeResult(response.data);
        }catch(err){
            if(err.response.status === 422){
                console.log(err.response.data);
                const data = err.response.data;
                data.output = data.errors.join("\n");
                delete data.errors;
                setCodeResult(data);
            }
        }
        setFetching(false);
    }

    return (
        <StaticLayout   >

            <div className="flex h-full items-stretch gap-4">
                <Card className="basis-1/2 p-4">
                    {/*<div className="overflow-y-auto h-full">*/}



                    {/*/>*/}
                    <CodeEditor onChange={(value) => setCode(value)}
                                storageId={"playground"}
                                className={`mb-4 h-[calc(100vh-var(--header-size)-var(--footer-size)-120px)]`}/>

                    {/*</div>*/}
                        <Button onClick={run} variant="contained"
                        >Run</Button>
                </Card>
                <Card className="basis-1/2 p-4 ">
                    <TabControl value={page}
                                orientation="horizontal"
                                onChange={(_e, p) => setPage(p)}
                                labels={[
                                    "Input",
                                    "Output",
                                ]}
                    />

                    <div className="h-full w-full px-4 py-8 overflow-y-auto">
                        <TabPanel index={1} value={page} className="h-full">
                            {fetching ? <div className="flex flex-col items-center ">
                                        <CircularProgress/>
                                        <div>
                                            Running
                                        </div>
                                </div> :
                                (codeResult.notExecuted ? <div>Not ran yet.</div>
                                        :

                                        <div className="h-full overflow-y-auto">
                                            <div className="flex gap-4 items-center mb-4">
                                                <div className="font-sans font-semibold">
                                                    Completed
                                                </div>
                                                {codeResult.runningTime &&
                                                    <div className="flex items-center gap-1">
                                                        <AccessTimeIcon/>
                                                        <span className="font-sans font-semibold">
                                        {codeResult.runningTime} ms
                                    </span>
                                                    </div>}

                                                {codeResult.memoryUsed &&
                                                    <div className="flex items-center gap-1">
                                                        <StorageIcon/>
                                                        <span className="font-sans font-semibold">
                                        {codeResult.memoryUsed} mb
                                    </span>
                                                    </div>}
                                            </div>
                                            <Typography component="div"
                                                        className="bg-gray-100 p-4 border rounded-md">
                                <pre style={{fontFamily: 'Roboto Mono, monospace', margin: 0}}>
                                    {codeResult.output}
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
                                )
                            }
                        </TabPanel>

                        {/*<TabPanel index={1} value={page}>*/}
                        {/*    <DashboardCompetitions/>*/}
                        {/*</TabPanel>*/}
                        {/*<TabPanel index={1} value={page}  className="h-full">*/}
                        {/*    <DashboardRoles/>*/}
                        {/*</TabPanel>*/}

                        <TabPanel index={0} value={page}  className="h-full">
                            <TextField name="input"
                                       fullWidth
                                       multiline
                                       value={input}
                                       onChange={(e) => setInput(e.target.value)}
                                       rows={10}
                                       className="pb-4"
                                       placeholder={"Enter input.."}/>
                        </TabPanel>
                    </div>


                </Card>
            </div>
        </StaticLayout>
    )
}