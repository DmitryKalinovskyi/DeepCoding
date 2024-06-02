import Container from "@mui/material/Container";
import {useEffect, useState} from "react";
import {Button, TableBody, TableCell, TableHead, TableRow, TextField} from "@mui/material";
import axios from "../../api/axios";
import {Link} from "react-router-dom";
import Table from "@mui/material/Table";
import useAuth from "../../hooks/useAuth.ts";

interface Role{
    Id: number,
    Name: string
}

export default function DashboardRoles(){
    const {auth} = useAuth();
    const [roles, setRoles] = useState<Role[]>([]);
    const [isLoading, setIsLoading] = useState(true);
    const [roleName, setRoleName] = useState("");

    async function fetchRoles(){
        const response = await axios.get("/api/roles",{
            headers: {
                "Authorization" : `Bearer ${auth.accessToken}`
            }
        });
        setRoles(response.data)
        setIsLoading(false);
    }

    async function handleSubmit(e){
        e.preventDefault()

        // setRoles( [...roles, roleName] )
        setRoleName("");
        const response = await axios.post("/api/roles", {Name: roleName},
            {
                headers: {
                    "Authorization" : `Bearer ${auth.accessToken}`
                }
            })
    }


    useEffect(() => {
        fetchRoles()
    }, []);

    return (
        <Container maxWidth="md">
            <form onSubmit={handleSubmit}>
                <TextField placeholder="Enter role name to add"
                           variant="standard"
                           name="Name"
                           value={roleName}
                           onChange={(e) => setRoleName(e.target.value)}
                           fullWidth/>
                <Table className="w-full mb-4">
                    <TableHead>
                        <TableRow>
                            <TableCell>Id</TableCell>
                            <TableCell>Name</TableCell>
                            <TableCell>Delete</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {roles.map((u) =>
                            <TableRow key={u.Id}>
                                <TableCell><Link to={`/profile/${u.Id}`} className="text-blue-500">{u.Id}</Link></TableCell>
                                <TableCell>{u.Name}</TableCell>
                                <TableCell>
                                    <Button variant="contained" color="error" onClick={() => setUserToDelete(u.Id)}>
                                        Delete
                                    </Button>
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </form>
        </Container>
    )
}