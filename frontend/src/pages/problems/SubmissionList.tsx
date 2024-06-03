import {useEffect, useState} from "react";
import {CircularProgress} from "@mui/material";
import axios from "../../api/axios";
import useAuth from "../../hooks/useAuth.ts";
import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import UnpublishedIcon from '@mui/icons-material/Unpublished';

interface Submission{
    Id: number,
    ProblemId: number,
    UserId: number,
    Code: string,
    Compiler: string,
    IsPassed: boolean,
    Result: object
}

interface SubmissionListProperties{
    ProblemId: number
}

function SubmissionList(props: SubmissionListProperties){
    const {auth} = useAuth();
    const [data, setData] = useState<Submission[]>([]);
    const [isFetching, setIsFetching] = useState(true);

    async function fetchSubmissions(){
        setIsFetching(true);

        const response = await axios.get(`/api/problems/${props.ProblemId}/submissions`,
            {
                headers:{
                    "Authorization" : `Bearer ${auth.accessToken}`
                }
            })

        console.log(response.data)
        // const data = response.data.map(s => {
        //     s.Result = JSON.parse(s.Result);
        //     return s;
        // })
        setData(response.data as Submission[]);
        setIsFetching(false);
    }

    useEffect(() => {
        fetchSubmissions()
    }, []);

    return (
        <div className="h-full p-2">
            {isFetching ? <div className="h-full flex justify-center items-center"><CircularProgress /></div>:
            <table className="submissions-table">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Status</td>
                        <td>Compiler</td>
                        <td>Runtime</td>
                        <td>Memory</td>
                    </tr>
                </thead>
                <tbody>
                {data.map((submission) =>
                    <tr onClick={()=>window.location.pathname=`submissions?id=${submission.Id}`}>
                        <td>
                            {submission.Id}
                        </td>
                        <td>
                            {submission.IsPassed ? <CheckCircleOutlineIcon color="success"/> : <UnpublishedIcon color="error"/>}
                        </td>
                        <td>
                            {submission.Compiler}
                        </td>
                        <td>
                            {submission.Result.runningTime}ms
                        </td>
                        <td>
                            {submission.Result.memoryUsed}mb
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
            }
        </div>
    );
}

export default SubmissionList;

