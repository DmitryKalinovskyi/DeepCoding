// import {alpha, FormControl, InputBase, InputLabel, MenuItem, Select, styled} from "@mui/material";
// import SearchIcon from '@mui/icons-material/Search';
import {useEffect, useRef, useState} from "react";
import Input from "../../shared/Input.tsx";
import {cn} from "../../lib/utils.ts";
import Select from "../../shared/Select.tsx";
import {Pagination} from "@mui/material";
import {Link} from "react-router-dom";


interface SearchResult {
    page: number,
    pageCount: number,
    problems: Problem[]
}

interface Problem{
    Id: number,
    Name: string,
    Description: string
}

interface SearchFilterParams{
    pageSize: 25
}

async function fetchProblems(search = "", page= 0, pageSize = 25) {
    const url = `http://deepcode/api/problems?` + new URLSearchParams({
        search,
        page: page.toString(),
        pageSize: pageSize.toString()
    });

    const response = await fetch(url);
    const result  = await response.json() as SearchResult;
    console.log("fetching result")
    console.log(result)
    return result
}


function ProblemsFilter(params: SearchFilterParams){
    const [isLoaded, setIsLoaded] = useState(false);
    const [isSearching, setIsSearching] = useState(false);
    const [problemsPage, setProblemsPage] = useState(1);

    const searchResult = JSON.parse(localStorage.getItem("searchResult") ?? "{}");
    let search_timeout: number;

    async function load(){
        const result = await fetchProblems();
        localStorage.setItem("searchResult", JSON.stringify(result));
        setIsLoaded(true);
    }

    async function onSearch(e){
        e.preventDefault();

        clearTimeout(search_timeout);
        search_timeout = setTimeout(async () => {
                setIsSearching(true);
                const result = await fetchProblems(
                    e.target.value
                )
                localStorage.setItem("searchResult", JSON.stringify(result));
                setIsSearching(false);
        },
            1000)
    }

    async function onPageChange(e, page: number){
        setProblemsPage(page);
        setIsSearching(true);
        const result = await fetchProblems(
            "",
            // api have zero positional page
            page-1
        )
        localStorage.setItem("searchResult", JSON.stringify(result));

        setIsSearching(false);
    }

    if(!isLoaded)
        load();

    const previewTable = [...Array(params.pageSize).keys()].map((_e, index) => {
        return <tr key={index}>
            <td className="w-60">
                <div className="preview-div w-32"/>
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
                <Select>
                    <option>Difficulty</option>
                    <option>Easy</option>
                    <option>Medium</option>
                    <option>Hard</option>
                </Select>

                <Select>
                    <option>Status</option>
                    <option>Never tried</option>
                    <option>Tried</option>
                    <option>Solved</option>
                </Select>

                <Select>
                    <option>Tags</option>
                    <option>Dynamic programming</option>
                    <option>Topological ordering</option>
                    <option>Two dimensional DP</option>
                </Select>

                <Input onChange={onSearch}
                       name="search"
                       placeholder="Enter problem name"/>
            </div>

            <div>
                <table className={cn("w-full problems-table", isSearching ? "is-searching" : "")}>
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
                    {isLoaded ? searchResult?.problems.map((problem) =>
                            <tr className="" key={problem.Id}>
                                <td className="w-60">
                                    Solved
                                </td>
                                <td>
                                    <Link to={`/problems/${problem.Id}`} className='hover:text-blue-500'>
                                        {problem.Id}. {problem.Name}
                                    </Link>
                                </td>
                            </tr>
                        ) :
                        previewTable
                    }
                    </tbody>
                </table>
            </div>

            {searchResult.pageCount > 0 &&
                <div className="flex justify-center">

                <Pagination count={searchResult.pageCount}
                            page={problemsPage}
                            onChange={onPageChange}

                />
                </div>
            }

        </div>
    );
}

export default ProblemsFilter;

