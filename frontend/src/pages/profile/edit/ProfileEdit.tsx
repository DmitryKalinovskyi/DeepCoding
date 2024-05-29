import StaticLayout from "../../../partial-pages/layout/StaticLayout.tsx";
import Card from "@mui/material/Card";
import {TabControl, TabPanel} from "../../../components/TabControl.tsx";
import {useState} from "react";
import ProfileEditProfile from "./ProfileEditProfile.tsx";
import Preferences from "./Preferences.tsx";

export default function ProfileEdit(){
    const [page, setPage] = useState(0);

    return (
        <StaticLayout>
            <div className="h-full flex flex-col">
                <Card className="flex-grow">
                    <div className="flex">
                        <TabControl value={page}
                                    orientation="vertical"
                                    onChange={(_e, p) => setPage(p)}
                                    labels={[
                                        "Profile",
                                        "Preferences",
                                    ]}
                        />

                        <TabPanel index={0} value={page} className="p-4">
                            <ProfileEditProfile/>
                        </TabPanel>

                        <TabPanel index={1} value={page}  className="p-4">
                            <Preferences/>
                        </TabPanel>
                    </div>
                </Card>
            </div>
        </StaticLayout>
    )
}