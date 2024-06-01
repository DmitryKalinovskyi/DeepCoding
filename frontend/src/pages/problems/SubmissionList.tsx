import {useEffect, useState} from "react";
import {CircularProgress} from "@mui/material";

interface Submission{
    Id: number,
    ProblemId: number,
    UserId: number,
    Code: string,
    Compiler: string,
}

interface SubmissionListProperties{
    ProblemId: number
}

const fetchSubmissions = async(problemId: number) => {
    const url = `http://deepcode/api/problems/${problemId}/submissions`;

    const response = await fetch(url);
    return await response.json() as Submission[];
}

function SubmissionList(props: SubmissionListProperties){

    const [data, setData] = useState<Submission[]>([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        setIsLoading(true);
        async function fetchAndSet(){
            const submissions = await fetchSubmissions(props.ProblemId);
            setData(submissions);
            setIsLoading(false);
        }

        fetchAndSet().then();
    }, [props]);

    return (
        <div className="h-full p-2">
            {isLoading ? <div className="h-full flex justify-center items-center"><CircularProgress /></div>:

            <table className="submissions-table">
                <thead>
                    <tr>
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
                            C++
                        </td>
                        <td>
                            20ms
                        </td>
                        <td>
                            20mb
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

