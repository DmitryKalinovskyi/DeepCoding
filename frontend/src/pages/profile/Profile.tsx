import DynamicLayout from "../../partial-pages/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
import YouTubeIcon from '@mui/icons-material/YouTube';
import GitHubIcon from '@mui/icons-material/GitHub';
import {Button, Divider} from "@mui/material";
import ContributionHeatmap from "./ContributionHeatmap.tsx";
import {Link} from "react-router-dom";

export default function Profile(){
    return (
        <DynamicLayout>
            <div className="flex gap-4">
                <div className="basis-1/4">
                    <Card className="p-4">
                        <div className="flex flex-col gap-4 mb-4">
                            <div className="flex gap-4">
                                <img src="/testAvatar.png" className="h-32 w-32 rounded-md"/>
                                <div>
                                    <div className="font-semibold text-xl">
                                        Dmytro Kalinovskyi
                                    </div>
                                    <div className="text-base">
                                        @deeperxd
                                    </div>
                                    <div className="flex items-center">
                                        <YouTubeIcon/> YouTube
                                    </div>
                                    <div className="flex items-center">
                                        <GitHubIcon/> GitHub
                                    </div>
                                </div>
                            </div>

                            <div className="flex gap-4 flex-wrap">
                                <Button variant="contained">Follow</Button>
                                <Button variant="contained">Unfollow</Button>

                                <Link to="/profile/edit">
                                    <Button variant="contained">Edit Profile</Button>
                                </Link>
                            </div>
                            <Divider flexItem/>
                            <div>
                                <div>
                                    Following: 20
                                </div>
                                <div>
                                    Follows: 20
                                </div>
                            </div>
                            <Divider flexItem/>

                            <div>
                                <div>
                                    Member since: 2022/10/20
                                </div>
                                <div>
                                    Last visit : 2022/10/20
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>

                <div className="basis-3/4">
                    <Card className="p-4">
                        <div className="flex gap-4">
                            <div className="basis-1/3">
                                <div className="font-semibold mb-4 text-xl">
                                    Statistics
                                </div>
                                <div className="flex gap-2 items-center">
                                    <div className="bg-blue-100 rounded-md p-2 text-lg basis-1/2">
                                        <div className="text-center">
                                            Solved problems
                                        </div>
                                        <div className="text-center">10</div>
                                    </div>
                                    <div className="bg-blue-100 rounded-md p-2 text-lg basis-1/2">
                                        <div className="text-center">Submissions</div>
                                        <div className="text-center">10</div>
                                    </div>
                                </div>
                            </div>
                            <Divider orientation="vertical" flexItem/>

                            <div className="basis-2/3">
                                <div className="font-semibold mb-4 text-xl">
                                Recent activity
                                </div>
                                <ContributionHeatmap/>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </DynamicLayout>
    )
}