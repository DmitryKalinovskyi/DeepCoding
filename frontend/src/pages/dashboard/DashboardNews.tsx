import React, { useState } from 'react';
import {Container, TextField, Button, Typography, Paper, Divider, CircularProgress, Alert} from '@mui/material';
import axios from "../../api/axios.ts";
import useAuth from "../../hooks/useAuth.ts";
import HTMLFrame from "../../shared/HTMLFrame.tsx";

interface News {
    Title: string;
    Content: string;
    Preview: string;
}

const DashboardNews = () => {
    const {auth} = useAuth();
    const [news, setNews] = useState<News>({
        Title: '',
        Content: '',
        Preview: '',
    });
    const [isPosting, setIsPosting] = useState(false);
    const [error, setError] = useState("");
    const [isChanged, setIsChanged] = useState(true);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setNews({
            ...news,
            [name]: value,
        });
        setIsChanged(true);
    };

    async function handleSubmit(e){
            e.preventDefault()
        try{
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            console.log(data)

            setIsPosting(true);
            await axios.post("api/news", data, {
                headers:{
                    "Authorization": "Bearer " + auth.accessToken
                }
            })
            setIsPosting(false);
            setIsChanged(false);
        }catch(err){
            setIsPosting(false);

            if(err.response.status == 422){
                setError(err.response.data.errors.toString());
            }
            else{
                console.log(err.message);
            }
        }
    }



    return (
        <div className="h-full">
        <Container maxWidth="md">
            <form method="post" onSubmit={handleSubmit}>
                <Typography variant="h4" component="h1" gutterBottom>
                    Create News
                </Typography>
                <TextField
                    label="Title"
                    name="Title"
                    value={news.Title}
                    onChange={handleChange}
                    fullWidth
                    required
                    margin="normal"
                />
                <TextField
                    label="Preview"
                    name="Preview"
                    value={news.Preview}
                    multiline
                    rows={10}
                    onChange={handleChange}
                    fullWidth
                    required
                    margin="normal"
                />
                <TextField
                    label="Content"
                    name="Content"
                    value={news.Content}
                    onChange={handleChange}
                    multiline
                    rows={10}
                    fullWidth
                    required
                    margin="normal"
                />
                    {isChanged ?
                <Button
                    variant="contained"
                    color="primary"
                    type="submit"
                    disabled={isPosting}
                >
                    {isPosting ? <CircularProgress size={24} /> : 'Submit'}
                </Button>
                        : <Alert>Posted!</Alert>}

                <Typography variant="h4" component="h1" gutterBottom className="mt-8">
                    Preview
                </Typography>
                <Paper className="p-4">
                    <Typography variant="h6" component="h3" gutterBottom>
                        {news.Title}
                    </Typography>
                    <HTMLFrame srcDoc={news.Preview}/>
                    <Divider/>
                    <HTMLFrame srcDoc={news.Content}/>
                </Paper>
            </form>

        </Container>
        </div>

    );
};

export default DashboardNews;
