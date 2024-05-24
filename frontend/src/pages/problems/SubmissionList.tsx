import React, {useEffect, useState} from "react";

interface Submission{
    Id: number,
    ProblemId: number,
    UserId: number,
    Code: string,
    Compiler: string,
}

interface SubmissionListProperties{
    UserId: number,
    ProblemId: number
}

const fetchSubmissions = async(userId: number, problemId: number) => {
    const url = `http://deepcode/api/submissions/problem?userId=${userId}=&problemId=${problemId}`;

    const response = await fetch(url);
    return await response.json() as Submission[];
}

function SubmissionList(props: SubmissionListProperties){

    const [data, setData] = useState<Submission[]>([]);
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        setIsLoading(true);
        async function fetchAndSet(){
            const submissions = await fetchSubmissions(props.UserId, props.ProblemId);
            setData(submissions);
            setIsLoading(false);
        }

        fetchAndSet().then();
    }, [props]);

    return (
        <div>
            {isLoading &&  <div>Loading...</div>}
            <ul>
                {data.map((submission) =>
                    <li>
                        <a href= {`submissions?id=${submission.Id}`} className='link text-decoration-none'>
                            {submission.Id}
                        </a>
                    </li>
                )}
            </ul>
        </div>
    );
}

export default SubmissionList;

