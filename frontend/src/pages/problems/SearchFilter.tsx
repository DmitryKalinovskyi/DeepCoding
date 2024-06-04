// import {alpha, FormControl, InputBase, InputLabel, MenuItem, Select, styled} from "@mui/material";
// import SearchIcon from '@mui/icons-material/Search';
import {useEffect, useRef, useState} from "react";
import Input from "../../shared/Input.tsx";
import {cn} from "../../lib/utils.ts";
import Select from "../../shared/Select.tsx";
import {Pagination} from "@mui/material";
import {Link} from "react-router-dom";
import axios from "../../api/axios.ts";
import useAuth from "../../hooks/useAuth.ts";

import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import AdjustIcon from '@mui/icons-material/Adjust';


interface SearchResult {
    page: number,
    pageCount: number,
    problems: Problem[]
}

interface Problem{
    TotalPassedAttempts: number;
    TotalAttempts: number;
    Id: number,
    Name: string,
    Difficulty: string,
    Status: string,
}

interface SearchFilterParams{
    pageSize: 10
}


function SearchFilter(params: SearchFilterParams){
    const [isLoaded, setIsLoaded] = useState(false);
    const [isSearching, setIsSearching] = useState(false);
    const [page, setPage] = useState(0);
    const [search, setSearch] = useState("");
    const {auth} = useAuth();
    const [result, setResult ] = useState();
    const [status, setStatus] = useState("");
    const [difficulty, setDifficulty] = useState("")

    let delayedSearchTimeout: number = 0;
    function setDelayedSearch(value){
        clearTimeout(delayedSearchTimeout);
        setTimeout(() => setSearch(value), 1000);
    }

    console.log("Render")
    useEffect(() => {
        async function fetch(){
            if(isLoaded)
                setIsSearching(true);
            try{

                console.log("search: " + search)
                const searchParams = new URLSearchParams({
                    name: search,
                    page: page.toString(),
                    pageSize: params.pageSize.toString(),
                    difficulty,
                    status
                });
                // const url = `/api/problems?` + searchParams;
                // window.location.search = searchParams.toString();

                const response = await axios.get(`/api/problems`, {
                    params: searchParams,
                    headers:{
                        "Authorization": `Bearer ${auth.accessToken}`
                    }
                });

                console.log(response.data)
                setResult(response.data)
            }catch(err){
                console.log(err.response.data);
            }
            finally {
                if(isLoaded)
                    setIsSearching(false);
                else
                    setIsLoaded(true)
            }
        }

        fetch();
    }, [page, search, status, difficulty]);

    const previewTable = [...Array(params.pageSize).keys()].map((_e, index) => {
        return <tr key={index}>
            <td className="w-60">
                <div className="preview-div w-32"/>
            </td>
            <td className="w-60">
                <div className="preview-div w-60"/>
            </td>
            <td className="w-60">
                <div className="preview-div w-60"/>
            </td>
            <td className="w-60">
                <div className="preview-div w-60"/>
            </td>
        </tr>
    });

    return (
        <div>
            <div className="flex items-stretch gap-4"
            >
                <Select onChange={(e) => setDifficulty(e.target.value)}>
                    <option value={""}>Difficulty</option>
                    <option>Easy</option>
                    <option>Medium</option>
                    <option>Hard</option>
                </Select>

                <Select onChange={(e) => setStatus(e.target.value)}>
                    <option value={""}>Status</option>
                    <option>Never tried</option>
                    <option>Tried</option>
                    <option>Solved</option>
                </Select>

                {/*<Select>*/}
                {/*    <option>Tags</option>*/}
                {/*    <option>Dynamic programming</option>*/}
                {/*    <option>Topological ordering</option>*/}
                {/*    <option>Two dimensional DP</option>*/}
                {/*</Select>*/}

                <Input onChange={(e) => setDelayedSearch(e.target.value)}
                       name="search"
                       placeholder="Enter problem name"/>
            </div>

            <div className="mb-4">
                <table className={cn("w-full problems-table", isLoaded && isSearching ? "is-searching" : "")}>
                    <thead>
                    <tr>
                        <td className="w-60">
                            Status
                        </td>
                        <td>
                            Title
                        </td>
                        <td>
                            Difficulty
                        </td>
                        <td>
                            Acceptance
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    {isLoaded ? result?.problems.map((problem) =>
                            <tr className="" key={problem.Id}>
                                <td className="w-60">
                                    {problem.Status == "Solved" ? <CheckCircleOutlineIcon color="success"/> : problem.Status === "Tried" && <AdjustIcon color="warning"/>}
                                </td>
                                <td>
                                    <Link to={`/problems/${problem.Id}`} className='hover:text-blue-500'>
                                        {problem.Name}
                                    </Link>
                                </td>
                                <td>
                                    {problem.Difficulty == "Easy" ?
                                        <div className="text-green-600">Easy</div>:problem.Difficulty == "Medium"?
                                        <div className="text-amber-600">Medium</div>: problem.Difficulty == "Hard"?
                                        <div className="text-red-600">Hard</div>: <div>{problem.Difficulty}</div>}
                                </td>
                                <td>
                                    {Math.round(problem.TotalPassedAttempts/problem.TotalAttempts*100)}%
                                </td>

                            </tr>
                        ) :
                        previewTable
                    }
                    </tbody>
                </table>
            </div>

            {result?.pageCount > 1 &&
                <div className="flex justify-center">

                <Pagination count={result?.pageCount}
                            page={page}
                            onChange={(p) => setPage(p)}

                />
                </div>
            }

        </div>
    );
}

export default SearchFilter;

