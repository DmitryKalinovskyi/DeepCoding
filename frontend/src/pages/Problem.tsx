import React, {useEffect, useState} from 'react';

import Header from '../partial-pages/Header'
import Footer from '../partial-pages/Footer'
import CodeEditor from "../partial-pages/CodeEditor";
import SubmissionList from "../partial-pages/SubmissionList";

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

function Problem(props: ProblemProperties){
    const [data, setData] = useState<Problem>();
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        setIsLoading(true);
        async function fetchAndSet(){
            const submissions = await fetchProblem(props.Id);
            setData(submissions);
            setIsLoading(false);
        }

        fetchAndSet().then();
    }, [props]);

    return (
        <div>
            <Header/>
            <div className="container py-5">
                <div className="row" >
                    <div className="col-md-12 col-lg-6 h-100">
                        <div className="bg-body-tertiary p-3 rounded-2 h-100">
                            <div className="h4">
                                Problem name: {data?.Name}
                            </div>
                            <div>
                                {data?.Description}
                            </div>
                        </div>
                    </div>
                    <div className="col-md-12 col-lg-6  h-100 d-flex flex-column">
                        <ul className="nav nav-tabs border-bottom-0 m-0" role="tablist">
                            <li className="nav-item" role="presentation">
                                <button className="nav-link active" id="editor-tab" data-bs-toggle="tab"
                                        data-bs-target="#actual-editor-tab-page" type="button" role="tab"
                                        aria-controls="actual-editor-tab-page" aria-selected="true">Editor
                                </button>
                            </li>
                            <li className="nav-item" role="presentation">
                                <button className="nav-link" id="submissions-tab" data-bs-toggle="tab"
                                        data-bs-target="#submissions-tab-page" type="button" role="tab"
                                        aria-controls="submissions-tab-page" aria-selected="false">Submissions
                                </button>
                            </li>
                        </ul>
                        <div className="bg-body-tertiary p-3 rounded-bottom-2 flex-grow-1">
                            <div className="tab-content h-100" id="editor-tab-content">
                                <div className="tab-pane fade show active h-100" id="actual-editor-tab-page"
                                     role="tabpanel">
                                    <CodeEditor/>
                                </div>
                                <div className="tab-pane fade h-100" id="submissions-tab-page" role="tabpanel">
                                    <SubmissionList UserId={1} ProblemId={1}/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>
    )
}


export default Problem;