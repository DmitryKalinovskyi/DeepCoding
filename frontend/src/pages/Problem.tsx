import {useEffect, useState} from 'react';

import CodeEditor from "../partial-pages/CodeEditor";
import SubmissionList from "../partial-pages/SubmissionList";
import DefaultLayout from "../partial-pages/layout/DefaultLayout.tsx";
import Box from '@mui/material/Box';
import {Tab, Tabs} from "@mui/material";
import Latex from "react-latex-next";

interface ProblemProperties{
    Id: number;
}

interface Problem{
    Id: number,
    Name: string,
    Description: string
}

const fetchProblem = async(id: number) => {
    const url = `http://deepcode/api/problems/problem?id=${id}`;

    const response = await fetch(url);
    return await response.json() as Problem;
}

interface TabPanelProps {
    children?: React.ReactNode;
    index: number;
    value: number;
}

function CustomTabPanel(props: TabPanelProps) {
    const { children, value, index, ...other } = props;

    return (
        <div
            className="flex-grow"
            role="tabpanel"
            hidden={value !== index}
            id={`simple-tabpanel-${index}`}
            aria-labelledby={`simple-tab-${index}`}
            {...other}
        >
            {value === index && (
                <Box className="p-2 h-full">
                    {children}
                </Box>
            )}
        </div>
    );
}

function a11yProps(index: number) {
    return {
        id: `simple-tab-${index}`,
        'aria-controls': `simple-tabpanel-${index}`,
    };
}


function Problem(props: ProblemProperties){
    const [data, setData] = useState<Problem>();
    const [isLoading, setIsLoading] = useState(false);
    const [tabIndex, setTabIndex] = useState(0);

    useEffect(() => {
        setIsLoading(true);
        async function fetchAndSet(){
            const submissions = await fetchProblem(props.Id);
            setData(submissions);
            setIsLoading(false);
        }

        fetchAndSet().then();
    }, [props]);

    async function onTabSwitch(e, value){
        setTabIndex(value);
    }

    return (
        <DefaultLayout>
            <div className="min-w-full min-h-full grid grid-cols-2 gap-8 ">
                <div className="p-3 rounded-md h-100 bg-gray-100">
                    <div className="text-2xl font-semibold mb-2">
                        Problem name: {data?.Name}
                    </div>
                    <div>
                        {data?.Description}
                    </div>
                </div>


                <div className="flex flex-col rounded-md bg-gray-100">
                    <Box>
                        <Tabs value={tabIndex} onChange={onTabSwitch} aria-label="basic tabs example"
                        className="rounded-t-md">
                            <Tab label="Editor" {...a11yProps(0)}  />
                            <Tab label="Submissions"  {...a11yProps(1)} />
                        </Tabs>
                    </Box>
                    <CustomTabPanel value={tabIndex} index={0} >
                        <CodeEditor/>
                    </CustomTabPanel>
                    <CustomTabPanel value={tabIndex} index={1}>
                        <SubmissionList UserId={1} ProblemId={1}/>
                    </CustomTabPanel>
                </div>

                {/*<div className="col-md-12 col-lg-6  h-100 d-flex flex-column">*/}
                {/*    <ul className="nav nav-tabs border-bottom-0 m-0" role="tablist">*/}
                {/*        <li className="nav-item" role="presentation">*/}
                {/*            <button className="nav-link active" id="editor-tab" data-bs-toggle="tab"*/}
                {/*                    data-bs-target="#actual-editor-tab-page" type="button" role="tab"*/}
                {/*                    aria-controls="actual-editor-tab-page" aria-selected="true">Editor*/}
                {/*            </button>*/}
                {/*        </li>*/}
                {/*        <li className="nav-item" role="presentation">*/}
                {/*            <button className="nav-link" id="submissions-tab" data-bs-toggle="tab"*/}
                {/*                    data-bs-target="#submissions-tab-page" type="button" role="tab"*/}
                {/*                    aria-controls="submissions-tab-page" aria-selected="false">Submissions*/}
                {/*            </button>*/}
                {/*        </li>*/}
                {/*    </ul>*/}
                {/*    <div className="bg-body-tertiary p-3 rounded-bottom-2 flex-grow-1">*/}
                {/*        <div className="tab-content h-100" id="editor-tab-content">*/}
                {/*            <div className="tab-pane fade show active h-100" id="actual-editor-tab-page"*/}
                {/*                 role="tabpanel">*/}
                {/*            </div>*/}
                {/*            <div className="tab-pane fade h-100" id="submissions-tab-page" role="tabpanel">*/}
                {/*            </div>*/}
                {/*        </div>*/}
                {/*    </div>*/}
                {/*</div>*/}
            </div>
        </DefaultLayout>

    )
}


export default Problem;