import {useEffect, useState} from 'react';
import DynamicLayout from "../../widgets/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
import axios from "../../api/axios.ts";
import HTMLFrame from '../../shared/HTMLFrame.tsx';
import {Button, CircularProgress, Pagination} from '@mui/material';
import Input from '../../shared/Input.tsx';
import { Link } from 'react-router-dom';


interface HomeViewModel{
    news: News[]
    pages: number
}

interface News{
    Id: number,
    Title: string,
    Content: string,
    Preview: string,
    CreatedTime: number
}

export default function Home(){
    const [data, setData] = useState<HomeViewModel>({news: [], pages: 0});
    const [isFetching, setIsFetching] = useState(false);
    const [page, setPage] = useState(0);
    const [search, setSearch] = useState("");

    async function getData() {
        setIsFetching(true);

        const response = await axios.get("api/news?" + new URLSearchParams({
            title: search,
            page: page.toString(),
            pageSize: "5"
        }));

        console.log(response.data);

        const data = response.data as HomeViewModel;
        setData(data);
        setIsFetching(false);
    }

    useEffect(() => {
        getData()

    }, []);

    async function onSearch(e){
        e.preventDefault();

        getData()
    }

    useEffect(() => {
        getData();
    }, [page]);

    return (
        <DynamicLayout>
            <div className="grid grid-cols-4 gap-4">
                <div className="col-span-3">

                    <form onSubmit={onSearch}>
                        <Input placeholder="Search news.."
                               className="mb-4 text-md"
                               onChange={(e) => setSearch(e.target.value)}
                        />
                    </form>
                    {isFetching ? <div className="my-8 flex justify-center"><CircularProgress/></div>:
                        (data?.news.map(news => {
                            return (
                                <Card key={news.Id} className="p-4 mb-4">
                                    <div className="rounded-2xl">
                                        <Link to={"/news/" + news.Id} className="text-3xl">{news.Title}</Link>
                                        <HTMLFrame srcDoc={news.Preview}/>
                                        <div className="flex justify-between">
                                            {/*<div><Button>Like</Button></div>*/}
                                            <div>{(new Date(news.CreatedTime * 1000)).toUTCString()}</div>
                                        </div>
                                    </div>
                                </Card>
                            )
                        }))}
                    {data.pages > 1 &&
                        <div className="flex justify-center">

                            <Pagination count={data.pages}
                                        page={page + 1}
                                        onChange={(_e, value) => setPage(value - 1)}

                            />
                        </div>
                    }
                </div>

                {/*<div className="">*/}
                {/*    <Card className="p-4">*/}
                {/*        <div className="font-semibold">*/}
                {/*            Users*/}
                {/*        </div>*/}
                {/*        <div>*/}
                {/*            Online: 20*/}
                {/*        </div>*/}
                {/*        <div>*/}
                {/*            Registered: 30*/}
                {/*        </div>*/}
                {/*    </Card>*/}
                {/*</div>*/}
            </div>
        </DynamicLayout>
    )
}

