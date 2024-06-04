import {useEffect, useState} from 'react';
import {Link, useParams} from 'react-router-dom';

import SubmitEditor from "./SubmitEditor.tsx";
import SubmissionList from "./SubmissionList.tsx";
import {TabControl, TabPanel} from "../../shared/TabControl.tsx";
import Card from '@mui/material/Card';
import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import {Button, CircularProgress} from "@mui/material";
import useIsInRole from "../../hooks/useIsInRole.ts";
import axios from '../../api/axios.ts';
import useAuth from "../../hooks/useAuth.ts";
import useIsAuthenticated from "../../hooks/useIsAuthenticated.ts";
import Select from "../../shared/Select.tsx";
import CodeEditor from "../../shared/CodeEditor.tsx";
import HTMLFrame from '../../shared/HTMLFrame.tsx';

interface Problem{
    Id: number,
    Name: string,
    Description: string,
    Status: string
}


function Problem(){
    const [problem, setProblem] = useState<Problem>();
    // const [isLoading, setIsLoading] = useState(true);
    const [tabIndex, setTabIndex] = useState(0);
    const {auth} = useAuth();
    const isAuthenticated = useIsAuthenticated();
    const params = useParams<{problemId: string}>();
    const isAdmin = useIsInRole("Admin");
    const [code, setCode] = useState("");
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [compiler, setCompiler] = useState("Python3");
    async function fetchProblem(){
        const response = await axios.get(`api/problems/${params.problemId}`);

        setProblem(response.data as Problem);
    }

    useEffect(() => {
        fetchProblem();
    }, []);

    async function submitProblem(){
        if(!isAuthenticated) return;

        try{

        console.log("submitting")
        setIsSubmitting(true);
        const response = await axios.post(`api/problems/${params.problemId}/submissions`,
            {
                code,
                compiler: "Python3"
            },
            {
                headers: {
                    "Authorization": `Bearer ${auth.accessToken}`
                }
            });

        console.log(response.data)
        }
        catch(err){
            console.log(err)
        }
        finally {
            setIsSubmitting(false);
        }
    }

    return (
        <StaticLayout >
            <div className="h-full grid grid-cols-2 gap-8 ">
                <Card className="relative h-full">
                    <div className="p-6 h-full overflow-y-auto mb-6">
                        <div className="text-2xl font-semibold mb-2">
                            Problem name: {problem?.Name}
                        </div>
                        <HTMLFrame srcDoc={problem?.Description}/>
                    </div>

                    <div className="absolute bottom-0 p-2 bg-white w-full flex">
                        {/*<Button className="w-20 h-6">Report</Button>*/}
                        {isAdmin && <Link to={`/problems/${params.problemId}/edit`}>
                            <Button className="w-20 h-6">Edit</Button>
                        </Link>}
                        {/*<Rating*/}
                        {/*        name="simple-controlled"*/}
                        {/*        value={rating}*/}
                        {/*        onChange={(_e, newRating) => {*/}
                        {/*            setRating(newRating ?? 0);*/}
                        {/*        }}*/}
                        {/*    />*/}
                    </div>
                </Card>


                <Card>
                    <div className="flex flex-col h-full">
                        <TabControl value={tabIndex}
                                    onChange={(_e, i) => setTabIndex(i)}
                                    labels={isAuthenticated ? [
                                        "Editor",
                                        "Submissions"
                                    ]: ["Editor"]}
                        />
                        <div className="p-4 h-full">
                            <TabPanel className="h-full" index={0} value={tabIndex}>
                                <div className="flex flex-col max-h-full">
                                    <div className="bg-light rounded-2">
                                        <div className="input-group mb-2">
                                            <Select onChange={(e) => setCompiler(e.target.value)}
                                                    value={compiler}>
                                                <option>Python3</option>
                                            </Select>
                                        </div>
                                    </div>
                                    <CodeEditor
                                        onChange={(value) => setCode(value)}
                                        storageId={params.problemId}
                                        className="h-[calc(100vh-var(--footer-size)-200px-var(--header-size))]"/>
                                    {/*<Button className="mt-4 w-20 bg-violet-700"*/}
                                    {/*        variant="contained"*/}
                                    {/*        onClick={submitProblem}*/}
                                    {/*>Send</Button>*/}
                                    {isAuthenticated &&
                                    <Button
                                        className="mt-4 w-20"
                                        variant="contained"
                                        color="secondary"
                                        onClick={submitProblem}
                                        disabled={isSubmitting}
                                    >
                                        {isSubmitting ? <CircularProgress size={24} /> : 'Send'}
                                    </Button>}
                                </div>
                            </TabPanel>
                            <TabPanel className="h-[calc(100%-40px)] overflow-y-auto" value={tabIndex} index={1}>
                                {params.problemId && <SubmissionList ProblemId={+params.problemId}/>}
                            </TabPanel>
                        </div>
                    </div>
                </Card>
            </div>
        </StaticLayout>

    )
}


export default Problem;