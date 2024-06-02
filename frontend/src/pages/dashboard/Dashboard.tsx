import {TabControl, TabPanel} from "../../shared/TabControl.tsx";
import {useState} from "react";
import DashboardProblems from "./DashboardProblems.tsx";
import DashboardUsers from "./DashboardUsers.tsx";
import DashboardCompetitions from "./DashboardCompetitions.tsx";
import {Button, Card} from "@mui/material";
import StaticLayout from "../../widgets/layout/StaticLayout.tsx";
import {Link} from "react-router-dom";
import DashboardNews from "./DashboardNews.tsx";

export default function Dashboard(){
    const [page, setPage] = useState(0);

    return (
        <StaticLayout haveFooter={false} haveHeader={false}>
            <div className="h-full flex flex-col" >
                <div className="mb-4">
                    <Link to="/"><Button variant="contained">Go to web site</Button></Link>
                </div>
                <Card className="flex-grow">
                <div className="flex h-full">
                    <TabControl value={page}
                                orientation="vertical"
                                onChange={(_e, p) => setPage(p)}
                                labels={[
                                    "Users",
                                    // "Competitions",
                                    "News",
                                    "Problems",
                                    "Resources",
                                    "Settings",
                                ]}
                    />

                    <div className="h-full w-full px-4 py-8 overflow-y-auto">
                        <TabPanel index={0} value={page}>
                            <DashboardUsers/>
                        </TabPanel>

                        {/*<TabPanel index={1} value={page}>*/}
                        {/*    <DashboardCompetitions/>*/}
                        {/*</TabPanel>*/}

                        <TabPanel index={1} value={page}>
                            <DashboardNews />
                        </TabPanel>
                        <TabPanel index={2} value={page}>
                            <DashboardProblems/>
                        </TabPanel>
                    </div>
                </div>
                </Card>
            </div>

        </StaticLayout>
    )
}