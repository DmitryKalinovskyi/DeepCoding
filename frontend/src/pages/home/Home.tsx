import {useEffect, useState} from 'react';
import DynamicLayout from "../../partial-pages/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
import {Avatar} from "@mui/material";

const fetchData = async () => {
    // const url = process.env.REACT_APP_API_URL_ADDRESS + "/home";
    const url = "http://deepcode/api/home";

    const response = await fetch(url);

    const data = await response.json();

    console.log(data);

    return data as HomeViewModel;
}

interface HomeViewModel{
    msg: string
}

export default function Home(){
    const [data, setData] = useState<HomeViewModel>();

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
                    {data?.msg}
                </div>
                <div className="">
                    <Card className="p-4">
                        <div className="font-semibold">
                            Users
                        </div>
                        <div>
                            Online: 20
                        </div>
                        <div>
                            Registered: 30
                        </div>
                    </Card>
                </div>
            </div>
        </DynamicLayout>
    )
}

