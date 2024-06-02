import Table from "@mui/material/Table";
import {useEffect, useState} from "react";
import axios from "../../api/axios";
import {
    Button,
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
}

interface UserRoles{

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
        const params = new URLSearchParams({
            login,
            page: page.toString(),
            pageSize: "10"
        })
        const response = await axios.get("api/users?" + params.toString())
        setIsFetching(false);

        // continue to fetch user roles.


        console.log(response.data);
        setData(response.data as DashboardUsersViewModel)
    }

    useEffect(() => {
        fetchUsers();
    }, []);

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

        console.log("deleted");
        fetchUsers();
    }

    async function closeDeleteDialog(){
        console.log("Deleted" + userToDelete);
    }

    return (
        <Container maxWidth="md">
            <form onSubmit={onSearch}>
            <TextField placeholder={"Enter user login"}
                       className="w-full mb-4"
                       variant="standard"
                       onChange={(e) => setLogin(e.target.value)}
                       InputProps={{
                           startAdornment: <InputAdornment position="start"><SearchIcon/></InputAdornment>,
                       }}/>
            </form>
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
                                <TableCell>Admin</TableCell>

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

            <Dialog
                open={userToDelete > -1}
                onClose={closeDeleteDialog}
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