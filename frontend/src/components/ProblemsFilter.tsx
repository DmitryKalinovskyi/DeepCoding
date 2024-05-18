import React, {useEffect, useState} from "react";


interface ProblemsFilter{
    page: number,
    pageCount: number,
    problems: Problem[]
}

interface Problem{
    Id: number,
    Name: string,
    Description: string
}

const fetchProblems = async() => {
    const url = "http://deepcode/api/problems";

    const response = await fetch(url);
    return await response.json() as ProblemsFilter;
}

function ProblemsFilter(){

    const [data, setData] = useState<ProblemsFilter>();
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        setIsLoading(true);
        async function fetchAndSet(){
            const problemsFilter = await fetchProblems();
            setData(problemsFilter);
            setIsLoading(false);
        }

        fetchAndSet();
    }, []);

    return (
        <div>
            <form className="row mb-2" method="get">
                <div className="col-2">
                    <select className="shadow-sm shadow-gray-300">
                        <option>All</option>
                        <option>Easy</option>
                        <option>Medium</option>
                        <option>Hard</option>
                    </select>
                </div>
                <div className="col-2">
                    <select className="form-select">
                        <option>None</option>
                        <option>Tag1</option>
                        <option>Tag2</option>
                        <option>Tag3</option>
                    </select>
                </div>

                <div className="col-2">
                    <select className="form-select">
                        <option>All</option>
                        <option>Not even tried</option>
                        <option>Tried</option>
                        <option>Solved</option>
                    </select>
                </div>
                <div className="col-6">

                    <div className="input-group">
                        <button className="input-group-text ">
                            <span className="bi bi-search"></span>
                        </button>
                        <input className="form-control"
                               name="search" placeholder="Enter problem name"/>
                    </div>
                </div>
            </form>

            <div>
                <table className="table">
                    <tbody>
                    {data?.problems.map((problem) =>
                            <tr>
                                <td>
                                    {problem.Id}
                                </td>
                                <td>
                                    <a href= {`problem?id=${problem.Id}`} className='link text-decoration-none'>
                                        {problem.Name}
                                    </a>
                                </td>
                            </tr>
                    )}
                    </tbody>
                </table>
                {isLoading && <tr><td colSpan={2}>Loading...</td></tr>}

            </div>
        </div>
    );
}

export default ProblemsFilter;

