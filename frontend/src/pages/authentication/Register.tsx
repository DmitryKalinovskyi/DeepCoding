import StaticLayout from "../../partial-pages/layout/StaticLayout.tsx";
import Card from "@mui/material/Card";
import Input from "../../components/Input.tsx";
import {Button} from "@mui/material";
import {Link} from "react-router-dom";

export default function Register(){
    return (
        <StaticLayout>
            <div className="flex items-center justify-center h-full">
                <Card className="p-4 w-96 ">
                    <div className="font-semibold text-2xl text-center mb-8">
                        Register
                    </div>
                    <Input placeholder="Login" className="mb-4"/>
                    <Input placeholder="Name" className="mb-4"/>
                    <Input placeholder="Password" className="mb-4"/>
                    <Input placeholder="Repeat password" className="mb-4"/>
                    <Button className="w-full mb-2" variant="contained">Register</Button>
                    <div className="text-center">
                        Have account?
                        <Link to="/login" className="text-blue-500"> Login</Link>
                    </div>
                </Card>
            </div>
        </StaticLayout>
    )
}