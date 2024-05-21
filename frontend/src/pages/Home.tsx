import React, {useEffect, useState} from 'react';
import Header from '../partial-pages/Header'
import Footer from '../partial-pages/Footer'
import {DefaultLayout} from "../partial-pages/layout/DefaultLayout.tsx";

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
        <DefaultLayout>
            <div>
                {data?.msg}
            </div>
        </DefaultLayout>
    )
}

