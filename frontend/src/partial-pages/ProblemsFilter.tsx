// import {alpha, FormControl, InputBase, InputLabel, MenuItem, Select, styled} from "@mui/material";
// import SearchIcon from '@mui/icons-material/Search';
import {useEffect, useState} from "react";
import Input from "../components/Input";


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
            <form className="flex " method="get">
                {/*<Input>*/}
                {/*    <option>Status</option>*/}
                {/*    <option>Not tried</option>*/}
                {/*    <option>Tried</option>*/}
                {/*    <option>Solved</option>*/}
                {/*</Input>*/}
                <select className="shadow-sm outline-0 border-2 rounded">

                </select>

                {/*<FormControl>*/}
                {/*<InputLabel id="status-select-label">Status</InputLabel>*/}
                {/*    <Select*/}
                {/*        labelId="status-select-label"*/}
                {/*        className="w-32"*/}
                {/*        label="Status"*/}
                {/*    >*/}
                {/*        <MenuItem>Not even tried</MenuItem>*/}
                {/*        <MenuItem>Tried</MenuItem>*/}
                {/*        <MenuItem>Solved</MenuItem>*/}
                {/*    </Select>*/}
                {/*</FormControl>*/}
                {/*<FormControl>*/}
                {/*    <InputLabel id="difficulty-select-label">Difficulty</InputLabel>*/}
                {/*    <Select*/}
                {/*        labelId="difficulty-select-label"*/}
                {/*        className="w-32"*/}
                {/*        label="Difficulty"*/}
                {/*    >*/}
                {/*        <MenuItem>Not even tried</MenuItem>*/}
                {/*        <MenuItem>Tried</MenuItem>*/}
                {/*        <MenuItem>Solved</MenuItem>*/}
                {/*    </Select>*/}
                {/*</FormControl>*/}

                {/*<div className="col-2">*/}
                {/*    <select className="shadow-sm shadow-gray-300">*/}
                {/*        <option>All</option>*/}
                {/*        <option>Easy</option>*/}
                {/*        <option>Medium</option>*/}
                {/*        <option>Hard</option>*/}
                {/*    </select>*/}
                {/*</div>*/}

                <div>
                </div>

                <div className="col-6">
                    <div className="input-group">
                        <button className="input-group-text ">
                            <span className="bi bi-search"></span>
                        </button>
                        <Input name="search" placeholder="Enter problem name"/>
                    </div>
                </div>
            </form>

            <div>
                <table className="w-full problems-table ">
                    <thead>
                        <tr>
                            <td className="w-60">
                                Status
                            </td>
                            <td>
                                Title
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    {!isLoading ? data?.problems.map((problem, index) =>
                            <tr className="" key={index}>
                                <td className="w-60">
                                    Solved
                                </td>
                                <td>
                                    <a href={`problem?id=${problem.Id}`} className='hover:text-blue-500'>
                                        {problem.Id}. {problem.Name}
                                    </a>
                                </td>
                            </tr>
                        ) :
                        <>
                            <tr>
                                <td className="w-60">
                                    <div className="preview-div w-40"/>
                                </td>
                                <td className="w-60">
                                    <div className="preview-div w-40"/>
                                </td>
                            </tr>
                            <tr>
                                <td className="w-60">
                                <div className="preview-div w-40"/>
                                </td>
                                <td className="w-60">
                                    <div className="preview-div w-40"/>
                                </td>
                            </tr>
                        </>
                    }
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default ProblemsFilter;

