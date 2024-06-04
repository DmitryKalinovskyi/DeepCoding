import DynamicLayout from "../../widgets/layout/DynamicLayout.tsx";
import Card from "@mui/material/Card";
// import YouTubeIcon from '@mui/icons-material/YouTube';
// import GitHubIcon from '@mui/icons-material/GitHub';
import {Button, Divider, Skeleton} from "@mui/material";
import ContributionHeatmap from "./ContributionHeatmap.tsx";
import {Link, useParams} from "react-router-dom";
import useAuth from "../../hooks/useAuth.ts";
import {useEffect, useState} from "react";
import axios from "../../api/axios.ts";

import moment from "moment"
import defaultAvatar from "/defaultAvatar.png"
import HTMLFrame from "../../shared/HTMLFrame.tsx";

export default function Profile(){
    const {auth} = useAuth();
    const [isLoading, setIsLoading] = useState(true);
    const [user, setUser] = useState({});
    const routeParams = useParams<{userId: string}>();

    async function fetchUser(){
        try{
            // const response = await axios.get(`api/users/${routeParams.userId}`);
            // const response2 = await axios.get(`api/users/${routeParams.userId}/followers/count`)
            // const response3 = await axios.get(`api/users/${routeParams.userId}/followings/count`)
            // const response4 = await axios.get(`api/users/${routeParams.userId}/following`,
            //     {
            //         headers: {
            //             "Authorization": `Bearer ${auth.accessToken}`
            //         }
            //     })
            // const data = response.data;
            // data.followersCount = response2.data.count;
            // data.followingsCount = response3.data.count;
            // data.isFollowing = response4.data.result;

            const response = await axios.get(`api/g/users/${routeParams.userId}`,{
                headers: {
                    "Authorization": `Bearer ${auth.accessToken}`
                }
            })

            console.log(response.data)
            setUser(response.data);
            setIsLoading(false);
        }
        catch(err: any){
            console.log(err.message);
        }
    }

    async function setFollow(follow: boolean){
        setUser({
            ...user,
            IsFollowed: follow
        });
        console.log("start fetching")
        const url = follow ? `api/users/${routeParams.userId}/follow` : `api/users/${routeParams.userId}/unfollow`;
        await axios.post(url,{}, {
            headers: {
                "Authorization": `Bearer ${auth.accessToken}`
            }
        })
        console.log("changed from " + user.IsFollowed + " to " + follow);
        fetchUser()
    }

    useEffect(() => {
        setIsLoading(true)
        fetchUser()
    }, [routeParams]);

    if(isLoading){
        // return skeleton
        return (<DynamicLayout>
            <div className="flex gap-4">
                <div className="basis-1/4">
                    <Card className="p-4">
                        <div className="flex flex-col gap-4 mb-4">
                            <div className="flex gap-4">
                                <Skeleton variant="rounded" className="h-32 w-32"/>
                                <div>
                                <Skeleton variant="rounded" className="w-32 mb-4"/>
                                <Skeleton variant="rounded" className="w-32"/>
                                </div>
                            </div>

                            <Skeleton variant="rounded" className="h-12 w-full"/>
                            <Divider flexItem/>
                            <Skeleton variant="rounded" className="h-12 w-full"/>
                            <Divider flexItem/>
                            <Skeleton variant="rounded" className="h-12 w-full"/>
                        </div>
                    </Card>
                </div>

                <div className="basis-3/4">
                    <Card className="p-4">
                        <div className="flex gap-4 h-40">
                            <div className="basis-1/3">
                                <Skeleton variant="rounded" className="h-full w-full"/>
                            </div>
                            <Divider orientation="vertical" flexItem/>

                            <div className="basis-2/3">
                                <Skeleton variant="rounded" className="h-full w-full"/>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </DynamicLayout>);
    }

    return (
        <DynamicLayout>
            <div className="flex gap-4">
                <div className="basis-1/4">
                    <Card className="p-4">
                        <div className="flex flex-col gap-4 mb-4">
                            <div className="flex gap-4 flex-wrap">
                                <img src={user.AvatarUrl}
                                     // onError={() => console.log("Image load fail.")}
                                     onError={(e) => e.target.src = defaultAvatar}
                                     className="h-32 w-32 object-cover rounded-md"/>
                                <div>
                                    <div className="font-semibold text-xl">
                                        {user.Name}
                                    </div>
                                    <div className="text-base">
                                        @{user.Login}
                                    </div>
                                    {/*<div className="flex items-center">*/}
                                    {/*    <YouTubeIcon/> YouTube*/}
                                    {/*</div>*/}
                                    {/*<div className="flex items-center">*/}
                                    {/*    <GitHubIcon/> GitHub*/}
                                    {/*</div>*/}
                                </div>
                            </div>

                            <div className="flex gap-4 flex-wrap">


                                {routeParams.userId == auth.userId ?
                                <Link to={`/profile/${routeParams.userId}/edit`}>
                                    <Button variant="contained">Edit Profile</Button>
                                </Link>:
                                <>
                                {user.IsFollowed?
                                    <Button variant="contained" onClick={() => setFollow(false)}>Unfollow</Button>:
                                    <Button variant="contained" onClick={() => setFollow(true)} >Follow</Button>}
                                </>
                                }
                            </div>
                            <Divider flexItem/>
                            <div>
                                <div>
                                    Following: {user.Followings}
                                </div>
                                <div>
                                    Follows: {user.Followers}
                                </div>
                            </div>
                            <Divider flexItem/>

                            <div>
                                <div>
                                    Member since: {moment(new Date(user.RegisterDate * 1000 ?? 0)).format("MMMM Do YYYY")}
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>

                <div className="basis-3/4">
                    <Card className="p-4 mb-4">
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
                    {user.Description != "" &&
                    <Card className="p-4">
                        <HTMLFrame srcDoc={user.Description}/>
                    </Card>}
                </div>
            </div>
        </DynamicLayout>
    )
}