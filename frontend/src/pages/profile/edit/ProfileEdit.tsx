import StaticLayout from "../../../widgets/layout/StaticLayout.tsx";
import Card from "@mui/material/Card";
import {TabControl, TabPanel} from "../../../shared/TabControl.tsx";
import {useState} from "react";
import ProfileEditProfile from "./ProfileEditProfile.tsx";
import Preferences from "./Preferences.tsx";

export default function ProfileEdit(){
    const [page, setPage] = useState(0);

    return (
        <StaticLayout>
            <div className="h-full flex flex-col">
                <Card className="flex-grow">
                    <div className="flex items-stretch h-full py-8">
                        <TabControl value={page}
                                    orientation="vertical"
                                    onChange={(_e, p) => setPage(p)}
                                    labels={[
                                        "Profile",
                                        // "Preferences",
                                    ]}
                        />

                        <div className="h-full w-full p-4 overflow-y-auto">

                        <TabPanel index={0} value={page} className="h-full">
                            <ProfileEditProfile/>
                        </TabPanel>

                        {/*<TabPanel index={1} value={page}  className="h-full">*/}
                        {/*    <Preferences/>*/}
                        {/*</TabPanel>*/}
                        </div>
                    </div>
                </Card>
            </div>
        </StaticLayout>
    )
}