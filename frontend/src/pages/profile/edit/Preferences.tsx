import {Button} from "@mui/material";

interface UserPreferences{
    "Show my submissions": boolean
    "Compiler": string
}

const userPreferences: UserPreferences = {
    "Show my submissions": false,
    "Compiler": "Python"
}

export default function Preferences(){
    return (<>
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
                Object.keys(userPreferences).map(k => {
                    return (
                        <tr key={k}>
                            <td>
                                {k}
                            </td>
                            <td>{userPreferences[k].toString()}</td>
                            <td>
                                <Button>Edit</Button>
                            </td>
                        </tr>
                    )
                })
            }
            </tbody>
        </table>
    </>)
}