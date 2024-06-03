import { useEffect, useState } from 'react';
import {useParams, useNavigate, Link} from 'react-router-dom';
import {Button, TextField, Card, CircularProgress, Divider} from '@mui/material';
import axios from '../../api/axios';
import useAuth from '../../hooks/useAuth';
import useIsInRole from '../../hooks/useIsInRole';
import DynamicLayout from '../../widgets/layout/DynamicLayout';
import useIsAuthenticated from "../../hooks/useIsAuthenticated.ts";
import HTMLFrame from "../../shared/HTMLFrame.tsx";

interface News {
    Id: number;
    Title: string;
    Preview: string;
    Content: string;
    CreatedTime: number;
}

export default function NewsEdit() {
    const [news, setNews] = useState<News>(
        { Id: 0, Title: '', Preview: '', Content: '', CreatedTime: 0 });
    const [isFetching, setIsFetching] = useState(true);
    const [isSaving, setIsSaving] = useState(false);
    const params = useParams<{ newsId: string }>();
    const navigate = useNavigate();
    const isAdmin = useIsInRole('Admin');
    const isAuthenticated = useIsAuthenticated();
    const {auth} = useAuth();

    async function fetchNews() {
        setIsFetching(true);
        const response = await axios.get(`api/news/${params.newsId}`);
        setNews(response.data);
        setIsFetching(false);
    }

    async function saveNews() {
        setIsSaving(true);
        const response = await axios.patch(`api/news/${params.newsId}`, news,
            {
                headers: {
                    "Authorization": `Bearer ${auth.accessToken}`
                }
            }
            );
        setIsSaving(false);
        navigate(`/news/${params.newsId}`);
    }

    useEffect(() => {
        fetchNews();
    }, []);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setNews((prevState) => ({
            ...prevState,
            [name]: value,
        }));
    };

    if (isFetching) {
        return (
            <DynamicLayout>
                <CircularProgress />
            </DynamicLayout>
        );
    }

    return (
        <DynamicLayout>
            <div className="grid grid-cols-4 gap-4">
                <div className="col-span-3">
                    <Card className="p-4 mb-4">
                        <form>
                            <TextField
                                name="Title"
                                label="Title"
                                value={news.Title}
                                onChange={handleInputChange}
                                fullWidth
                                margin="normal"
                            />
                            <TextField
                                name="Preview"
                                label="Preview"
                                value={news.Preview}
                                onChange={handleInputChange}
                                fullWidth
                                multiline
                                rows={10}
                                margin="normal"
                            />
                            <TextField
                                name="Content"
                                label="Content"
                                value={news.Content}
                                onChange={handleInputChange}
                                fullWidth
                                multiline
                                rows={10}
                                margin="normal"
                            />
                            <div className="flex justify-end gap-4 mt-4">
                                <Button
                                    variant="contained"
                                    onClick={() => navigate(`/news/${params.newsId}`)}
                                >
                                    Cancel
                                </Button>
                                <Button
                                    variant="contained"
                                    color="primary"
                                    onClick={saveNews}
                                    disabled={isSaving}
                                >
                                    {isSaving ? <CircularProgress size={24} /> : 'Save'}
                                </Button>
                            </div>
                        </form>
                    </Card>
                    <Card className="p-4">
                        <Link to={"/news/" + news.Id} className="text-3xl">{news.Title}</Link>
                        <HTMLFrame srcDoc={news.Preview}/>
                        <Divider/>
                        <HTMLFrame srcDoc={news.Content}/>
                    </Card>
                </div>
            </div>
        </DynamicLayout>
    );
}
