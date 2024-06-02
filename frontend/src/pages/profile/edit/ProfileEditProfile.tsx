import Input from "../../../shared/Input.tsx";
import {Alert, Button, CircularProgress, Container, TextField} from "@mui/material";
import useAuth from "../../../hooks/useAuth.ts";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../../../api/axios.ts";
import HTMLFrame from "../../../shared/HTMLFrame.tsx";

interface UserProperties {
    Name: string
    AvatarUrl: string
    Description: string
}

export default function ProfileEditProfile() {
    const { auth } = useAuth();
    const [isLoading, setIsLoading] = useState(true);
    const [isPatching, setIsPacthing] = useState(false);
    const [user, setUser] = useState<UserProperties>({ Name: '', Password: '', Description: '' });
    const routeParams = useParams<{ userId: string }>();
    const [changed, setChanged] = useState(true);

    async function fetchMe() {
        try {
            setIsLoading(true);
            const response = await axios.get(`api/users/${routeParams.userId}`, {
                headers: {
                    "Authorization": "Bearer " + auth.accessToken
                }
            });

            console.log("response", response.data);
            setUser(response.data);
            setIsLoading(false);
        } catch (err: any) {
            console.log(err.message);
        }
    }

    useEffect(() => {
        fetchMe();
    }, []);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setChanged(true);
        setUser(prevState => ({
            ...prevState,
            [name]: value
        }));
    };

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        try {
            setIsPacthing(true);
            const response = await axios.patch(`api/users/${routeParams.userId}`, user, {
                headers: {
                    "Authorization": "Bearer " + auth.accessToken
                }
            });
            console.log("User updated:", response.data);
            setChanged(false);
        } catch (err: any) {
            console.log("Update failed", err.message);
        }
        setIsPacthing(false);
    };

    if (isLoading) {
        return <div className="w-full h-full flex justify-center items-center"><CircularProgress /></div>;
    }

    return (
        <Container maxWidth="md">

        <form onSubmit={handleSubmit}>
            <TextField
                name="Name"
                value={user.Name}
                onChange={handleChange}
                label="Name"
                className="mb-4"
                fullWidth
            />

            <TextField
                name="AvatarUrl"
                value={user.AvatarUrl}
                onChange={handleChange}
                label="AvatarUrl"
                className="mb-4"
                fullWidth
            />

            <TextField
                name="Description"
                value={user.Description}
                label="Description"
                multiline
                className="mb-4"
                rows={10}
                onChange={handleChange}
                fullWidth
            />
            <div className="mb-4">

            {isPatching ? <CircularProgress/> :
                changed ? <Button type="submit" variant="contained" color="primary" >Save</Button>
                    : <Alert severity="success">Updated!</Alert>
            }
            </div>
        </form>
            <HTMLFrame srcDoc={user.Description}/>
        </Container>

    );
}
