import {TabControl, TabPanel} from "../../components/TabControl.tsx";
import {useState} from "react";
import DashboardProblems from "./DashboardProblems.tsx";
import DashboardUsers from "./DashboardUsers.tsx";
import DashboardCompetitions from "./DashboardCompetitions.tsx";
import {Button, Card} from "@mui/material";
import StaticLayout from "../../partial-pages/layout/StaticLayout.tsx";

export default function Dashboard(){
    const [page, setPage] = useState(0);

    return (
        <StaticLayout haveFooter={false} haveHeader={false}>
            <div className="h-full flex flex-col" >
                <div className="mb-4">
                    <Button variant="contained">Go to web site</Button>
                </div>
                <Card className="flex-grow">
                <div className="flex">
                    <TabControl value={page}
                                orientation="vertical"
                                onChange={(_e, p) => setPage(p)}
                                labels={[
                                    "Users",
                                    "Competitions",
                                    "Problems",
                                    "Resources",
                                    "Settings",
                                ]}
                    />

                    <TabPanel index={0} value={page}>
                        <DashboardUsers/>
                    </TabPanel>

                    <TabPanel index={1} value={page}>
                        <DashboardCompetitions/>
                    </TabPanel>

                    <TabPanel index={2} value={page}>
                        <DashboardProblems/>
                    </TabPanel>
                </div>
                </Card>
            </div>

        </StaticLayout>
    )
}