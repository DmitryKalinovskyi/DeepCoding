import {useEffect, useState} from 'react';
import DynamicLayout from "../../widgets/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
import axios from "../../api/axios.ts";

const fetchData = async () => {
    const response = await axios.get("api/news");

    console.log(response.data);

    return response.data as News;
}

interface News{
    Id: number,
    Title: string,
    Content: string,
    Preview: string,
    CreatedTime: number
}

export default function Home(){
    const [data, setData] = useState<News>();

    useEffect(() => {
        async function getData() {
            const fetchedData = await fetchData();
            setData(fetchedData);
        }

        getData()

    }, []);

    return (
        <DynamicLayout>
            <div className="grid grid-cols-4 gap-4">
                <div className="col-span-3">

                </div>
            </div>
        </DynamicLayout>
    )
}

