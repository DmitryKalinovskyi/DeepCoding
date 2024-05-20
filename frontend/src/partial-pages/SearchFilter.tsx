// import {alpha, FormControl, InputBase, InputLabel, MenuItem, Select, styled} from "@mui/material";
// import SearchIcon from '@mui/icons-material/Search';
import {useEffect, useRef, useState} from "react";
import Input from "../components/Input";
import {cn} from "../lib/utils.ts";


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
    pageSize?: 25
}

async function fetchProblems(search = "") {
    const url = `http://deepcode/api/problems?` + new URLSearchParams({
        search
    });

    const response = await fetch(url);
    return await response.json() as SearchResult;
}


function ProblemsFilter(params: SearchFilterParams){
    const [isLoaded, setIsLoaded] = useState(false);
    const [isSearching, setIsSearching] = useState(false);

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

    if(!isLoaded)
        load();

    const previewTable = [...Array(params.pageSize ?? 20).keys()].map((_e, index) => {
        return <tr key={index}>
            <td className="w-60">
                <div className="preview-div w-32"/>
            </td>
            <td className="w-60">
                <div className="preview-div w-40"/>
            </td>
        </tr>
    });

    return (
        <div>
            <div className="flex"
            >
                <select className="shadow-sm outline-0 border-2 rounded">

                </select>

                <div className="col-6">
                    <div className="input-group">
                        <button className="input-group-text ">
                            <span className="bi bi-search"></span>
                        </button>
                        <Input onChange={onSearch}
                               name="search" placeholder="Enter problem name"/>
                    </div>
                </div>
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
                                    <a href={`problem?id=${problem.Id}`} className='hover:text-blue-500'>
                                        {problem.Id}. {problem.Name}
                                    </a>
                                </td>
                            </tr>
                        ) :
                        previewTable
                    }
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default ProblemsFilter;

