import Table from "@mui/material/Table";
import {useEffect, useState} from "react";
import axios from "../../api/axios";
import {
    Button, CircularProgress,
    Container,
    Dialog,
    DialogActions,
    DialogTitle,
    InputAdornment,
    Pagination,
    TableBody,
    TableCell,
    TableHead,
    TableRow,
    TextField
} from "@mui/material";

import SearchIcon from '@mui/icons-material/Search';
import { Link } from "react-router-dom";
import useAuth from "../../hooks/useAuth.ts";

interface DashboardUsersViewModel{
    users: User[],
    pages: number
}

interface User{
    Id: number,
    Login: string,
    Name: string,
    Roles?: string[]
}

export default function DashboardUsers(){
    const [isFetching, setIsFetching] = useState(false)
    const [login, setLogin] = useState("");
    const [page, setPage] = useState(0);
    const [data, setData] = useState<DashboardUsersViewModel>({
        users: [],
        pages: 0
    });

    const {auth} = useAuth();

    const [userToDelete, setUserToDelete ] = useState(-1);

    async function fetchUsers(){
        setIsFetching(true);
        try{
            const params = new URLSearchParams({
                login,
                page: page.toString(),
                pageSize: "10"
            })
            const response = await axios.get("api/users?" + params.toString())

            const data = response.data as DashboardUsersViewModel;
            // continue to fetch user roles.
            await Promise.all(data.users.map(async (u) => {
                try {
                    const roleResponse = await axios.get(`api/users/${u.Id}/roles`, {
                        headers: {
                            "Authorization": `Bearer ${auth.accessToken}`
                        }
                    });

                    u.Roles = roleResponse.data.map(role => role.Name);
                    return u;
                } catch (error) {
                    // Handle errors if axios request fails
                    console.error(`Error fetching roles for user ${u.Id}:`, error);
                    return u; // Return u with original roles if request fails
                }
            }));
            setData(data);
        }catch(err){
            console.log(err.message);
        }

        setIsFetching(false);
    }

    useEffect(() => {
        fetchUsers();
    }, [page]);

    async function onSearch(e){
        e.preventDefault();

        fetchUsers()
    }

    async function deleteUser(id: number){
        setUserToDelete(-1);
        const response = await axios.delete("api/users/" + id, {
            headers: {
                "Authorization": `Bearer ${auth.accessToken}`
            }
        });

        // compose it into signle object

        console.log("deleted");
        fetchUsers();
    }

    const table = isFetching ? <div className="container flex justify-center items-center"><CircularProgress/></div> :
        <Table className="w-full mb-4">
            <TableHead>
                <TableRow>
                    <TableCell>Id</TableCell>
                    <TableCell>Login</TableCell>
                    <TableCell>Name</TableCell>
                    <TableCell>Roles</TableCell>
                    {/*<TableCell>Update</TableCell>*/}
                    <TableCell>Delete</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>

                {data.users.map((u) =>
                    <TableRow key={u.Id}>
                        <TableCell><Link to={`/profile/${u.Id}`} className="text-blue-500">{u.Id}</Link></TableCell>
                        <TableCell>{u.Login}</TableCell>
                        <TableCell>{u.Name}</TableCell>
                        <TableCell>{u.Roles?.toString()}</TableCell>

                        {/*<TableCell><Button variant="contained" color="warning">Update</Button></TableCell>*/}
                        <TableCell>
                            <Button variant="contained" color="error" onClick={() => setUserToDelete(u.Id)}>
                                Delete
                            </Button>
                        </TableCell>
                    </TableRow>
                )}
            </TableBody>
        </Table>
    ;

    return (
        <Container maxWidth="md">
            <form onSubmit={onSearch}>
            <TextField placeholder={"Enter user login"}
                       className="w-full mb-4"
                       variant="standard"
                       value={login}
                       onChange={(e) => setLogin(e.target.value)}
                       InputProps={{
                           startAdornment: <InputAdornment position="start"><SearchIcon/></InputAdornment>,
                       }}/>
            </form>

            {table}

            <Dialog
                open={userToDelete > -1}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
            >
                <DialogTitle id="alert-dialog-title">
                    {`You sure you want to delete that user?`}
                </DialogTitle>
                {/*<DialogContent>*/}
                {/*    <DialogContentText id="alert-dialog-description">*/}
                {/*        */}
                {/*    </DialogContentText>*/}
                {/*</DialogContent>*/}
                <DialogActions>
                    <Button onClick={() => setUserToDelete(-1)}>Cancel</Button>
                    <Button onClick={() => deleteUser(userToDelete)} color="error" >
                        Delete any way
                    </Button>
                </DialogActions>
            </Dialog>


            {data.pages > 1 &&
                <div className="flex justify-center">
                    <Pagination count={data.pages}
                                page={page + 1}
                                onChange={(_e, value) => setPage(value - 1)}

                    />
                </div>
            }
        </Container>

    )
}