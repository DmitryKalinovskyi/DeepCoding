import {useEffect, useState} from 'react';
import DynamicLayout from "../../widgets/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
import axios from "../../api/axios.ts";
import {Link, useNavigate, useParams} from "react-router-dom";
import HTMLFrame from "../../shared/HTMLFrame.tsx";
import useAuth from '../../hooks/useAuth.ts';
import useIsInRole from "../../hooks/useIsInRole.ts";
import {Button, Dialog, DialogActions, DialogTitle, Skeleton} from '@mui/material';



interface News {
    Id: number,
    Title: string,
    Content: string,
    CreatedTime: number
}

export default function NewsPage(){
    const [news, setNews] = useState<News>();
    const [isFetching, setIsFetching] = useState(true);
    const params = useParams<{newsId: string}>()
    const isAdmin = useIsInRole("Admin")
    const [isDeleteDialogShown, setIsDeleteDialogShown] = useState(false);
    const {auth} = useAuth();
    const navigate = useNavigate();
    async function fetchNews(){
        setIsFetching(true);
        const response = await axios.get(`api/news/${params.newsId}`);
        console.log(response.data);
        setNews(response.data);
        setIsFetching(false);
    }

    useEffect(() => {

        fetchNews();

    }, []);

    async function deleteNews(){
        setIsDeleteDialogShown(false);
        const response = await axios.delete(`api/news/${params.newsId}`,
            {
                headers:{
                    "Authorization": `Bearer ${auth.accessToken}`
                }
            });

        console.log(response.data);
        navigate("/")
    }

    return (
        <DynamicLayout>
            <div className="grid grid-cols-4 gap-4">
                <div className="col-span-3">
                    {isAdmin && <div className="mb-4">
                        <Link to={`/news/${params.newsId}/edit`}>
                            <Button variant="contained" className="mr-4">Edit</Button>
                        </Link>
                        <Button variant="contained"
                                color="error"
                                onClick={() => setIsDeleteDialogShown(true)}>Delete</Button>
                    </div>}

                    <Card className="p-4 mb-4">
                        {isFetching ?
                            <div className="flex flex-col gap-4" >
                                <Skeleton variant="rounded" className="h-20 w-96"/>
                                <Skeleton variant="rounded" className="h-12"/>
                                <Skeleton variant="rounded" className="h-32"/>
                                <Skeleton variant="rounded" className="h-12"/>
                                <Skeleton variant="rounded" className="h-32"/>
                                <Skeleton variant="rounded" className="h-96"/>
                            </div>:
                            <div className="rounded-2xl">
                                <Link to={"/news/" + news.Id} className="text-3xl">{news.Title}</Link>
                                <HTMLFrame srcDoc={news.Content}/>
                                <div className="flex justify-between">
                                    {/*<div><Button>Like</Button></div>*/}
                                    <div>{(new Date(news.CreatedTime * 1000)).toUTCString()}</div>
                                </div>
                            </div>
                        }
                    </Card>

                    <Dialog
                        open={isDeleteDialogShown}
                        aria-labelledby="alert-dialog-title"
                        aria-describedby="alert-dialog-description"
                    >
                        <DialogTitle id="alert-dialog-title">
                            {`You sure you want to delete that news?`}
                        </DialogTitle>
                        {/*<DialogContent>*/}
                        {/*    <DialogContentText id="alert-dialog-description">*/}
                        {/*        */}
                        {/*    </DialogContentText>*/}
                        {/*</DialogContent>*/}
                        <DialogActions>
                            <Button onClick={() => setIsDeleteDialogShown(false)}>Cancel</Button>
                            <Button onClick={() => deleteNews()} color="error" >
                                Delete any way
                            </Button>
                        </DialogActions>
                    </Dialog>
                </div>
            </div>
        </DynamicLayout>
    )
}

