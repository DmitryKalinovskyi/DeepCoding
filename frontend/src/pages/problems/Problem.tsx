import {useEffect, useState} from 'react';
import {useParams} from 'react-router-dom';

import SubmitEditor from "./SubmitEditor.tsx";
import SubmissionList from "./SubmissionList.tsx";
import {TabControl, TabPanel} from "../../components/TabControl.tsx";
import Card from '@mui/material/Card';
import StaticLayout from "../../partial-pages/layout/StaticLayout.tsx";
import {Button} from "@mui/material";

interface Problem{
    id: number,
    name: string,
    description: string
}

const fetchProblem = async(id: number) => {
    const url = `http://deepcode/api/problems/problem?id=${id}`;

    const response = await fetch(url);
    const result = await response.json();
console.log(result);
    return {
        id: result.Id,
        name: result.Name,
        description: result.Description
    }
}
function Problem(){
    const [data, setData] = useState<Problem>();
    const [isLoading, setIsLoading] = useState(true);
    const [tabIndex, setTabIndex] = useState(0);

    const params = useParams<{problemId: string}>();



    useEffect(() => {
        async function fetchAndSet(){
            const submissions = await fetchProblem(params.problemId);
            setData(submissions);
            setIsLoading(false);
        }

        fetchAndSet().then();
    }, []);

    return (
        <StaticLayout useTinyHeader={false} >
            <div className="h-full grid grid-cols-2 gap-8 ">
                <Card className="relative h-full">
                    <div className="p-6 h-full overflow-y-auto mb-6">
                        <div className="text-2xl font-semibold mb-2">
                            Problem name: {data?.name}
                        </div>
                        <div>
                            {data?.description}
                        </div>
                    </div>

                    <div className="absolute bottom-0 p-2 bg-white w-full flex">
                        <Button className="w-20 h-6">Report</Button>
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
                                    labels={[
                                        "Editor",
                                        "Submissions"
                                    ]}
                        />
                        <div className="p-4 h-full">
                            <TabPanel className="h-full" index={0} value={tabIndex}>
                                <SubmitEditor/>
                            </TabPanel>
                            <TabPanel className="h-full" value={tabIndex} index={1}>
                                <SubmissionList UserId={1} ProblemId={1}/>
                            </TabPanel>
                        </div>
                    </div>
                </Card>
            </div>
        </StaticLayout>

    )
}


export default Problem;