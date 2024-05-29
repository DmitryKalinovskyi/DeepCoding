import Input from "../../../components/Input.tsx";
import {Button} from "@mui/material";

interface UserProperties{
    Name: string,
    Location: string,
    GitHub: string,
    YouTube: string,
    Twitter: string,
    Website: string,
}

const userProperties: UserProperties = {
    Name: "Dmytro Kalinovskyi",
    Location: "Ukraine, Zhytomyr",
    GitHub: "https://github.com/DmitryKalinovskyi",
    YouTube: "",
    Twitter: "",
    Website: "",
}

export default function ProfileEditProfile(){
    return (
        <>
            <table>
                <thead>
                    <tr>
                        <td className="w-32"></td>
                        <td className="w-96"></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                {
                    Object.keys(userProperties).map(k => {
                        return (
                            <tr key={k}>
                                <td>
                                    {k}
                                </td>
                                <td>{userProperties[k]}</td>
                                <td>
                                    <Button>Edit</Button>
                                </td>
                            </tr>
                        )
                    })
                }
                </tbody>
            </table>
        </>
    )
}