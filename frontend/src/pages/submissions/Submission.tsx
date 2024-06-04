import { useEffect, useState } from "react";
import {Link, useParams } from "react-router-dom";
import { Paper, Typography, Grid, Divider, Table, TableRow, TableContainer, TableHead, TableCell, TableBody } from "@mui/material";
import DynamicLayout from "../../widgets/layout/DynamicLayout";
import axios from "../../api/axios";
import {PieChart} from "@mui/x-charts";

import moment from "moment";
import CheckCircleOutlineIcon from "@mui/icons-material/CheckCircleOutline";
import UnpublishedIcon from "@mui/icons-material/Unpublished";

interface Submission {
    Id: number;
    ProblemId: number;
    UserId: number;
    Code: string;
    Compiler: string;
    IsPassed: boolean;
    Result: {
        tests: {
            name: string;
            isPassed: boolean;
            memoryUsed: number;
            runningTime: number;
        }[];
        memoryUsed: number;
        runningTime: number;
    };
    CreatedTime: number;
    UserLogin: string,
    ProblemName: string
}

export default function Submission() {
    const [submission, setSubmission] = useState<Submission | null>(null);
    const [isFetching, setIsFetching] = useState(true);
    const params = useParams<{ submissionId: string }>();

    useEffect(() => {
        async function fetchSubmission() {
            try {
                const response = await axios.get(`api/submissions/${params.submissionId}`);
                setSubmission(response.data);
                console.log(response.data);
            } catch (error) {
                console.error("Error fetching submission:", error);
            } finally {
                setIsFetching(false);
            }
        }
        fetchSubmission();
    }, [params.submissionId]);

    if (isFetching) {
        return <p>Loading...</p>;
    }

    const calculateTests = () => {
        if (!submission) return [0, 0];
        const totalTests = submission.Result.tests.length;
        const passedTests = submission.Result.tests.filter(test => test.isPassed).length;
        return [passedTests, totalTests - passedTests];
    };

    const getElapsedTime = () => {
        const date = new Date(submission?.CreatedTime * 1000 ?? 0);
        return moment(date).fromNow();
    }

    const percent = (a: number, total: number) => {
        return Math.floor(a/total * 100)
    }

    const [passedTests, notPassed] = calculateTests();

    return (
        <DynamicLayout>
            {submission && (
                <Paper elevation={3} className="p-4 rounded-lg">
                    <div className="flex justify-around  mb-8">
                        <div>
                            <div className="font-bold text-xl">Problem</div>
                            <Link to={`/problems/${submission.ProblemId}`} className="underline">
                                {submission.ProblemName}
                            </Link>
                        </div>
                        <div>
                            <div className="font-bold text-xl">Submitted</div>
                            <div>
                                {getElapsedTime()}
                            </div>
                        </div>
                        <div>
                            <div className="font-bold text-xl">Compiler</div>
                            <div>{submission.Compiler}</div>
                        </div>
                        <div>
                            <div className="font-bold text-xl">Author</div>
                            <Link to={`/profile/${submission.UserId}`} className="underline">
                                {submission.UserLogin}
                            </Link>
                        </div>
                    </div>
                    <Divider/>
                    <div className="flex justify-center items-center">
                        <div className="relative">
                            <PieChart
                                slotProps={
                                    {
                                        legend: { hidden: true }
                                    }
                                }
                                tooltip={{ trigger: 'item' }}

                                series={[
                                {
                                    data: [
                                        { value: passedTests, label: 'Passed' , color: "#37c45f"},
                                        { value: notPassed, label: 'Not passed' , color: "#e8f5e9"},
                                    ],
                                    innerRadius: 140,
                                    outerRadius: 150,
                                    cx:195,
                                    cy:195,
                                    cornerRadius: 5,
                                },
                            ]} width={400}
                            height={400}/>
                            <div className="h-full w-full absolute flex justify-center items-center top-0 pointer-events-none">
                                <div className="text-4xl" >{percent(passedTests, passedTests + notPassed)}%</div>
                            </div>
                        </div>
                    </div>
                    <TableContainer component={Paper}>
                        <Table sx={{ minWidth: 650 }} aria-label="simple table">
                            <TableHead>
                                <TableRow>
                                    <TableCell>IsPassed</TableCell>
                                    <TableCell >Test name</TableCell>
                                    <TableCell >Runtime</TableCell>
                                    <TableCell >Memory</TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {submission.Result.tests.map((test) => (
                                    <TableRow
                                        key={test.name}
                                        sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                    >
                                        <TableCell component="th" scope="row">
                                            {test.isPassed ? <CheckCircleOutlineIcon color="success"/> : <UnpublishedIcon color="error"/>}
                                        </TableCell>
                                        <TableCell >{test.name}</TableCell>
                                        <TableCell >{test.runningTime} ms</TableCell>
                                        <TableCell >{test.memoryUsed} mb</TableCell>
                                    </TableRow>
                                ))}
                                <TableRow
                                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                >
                                    <TableCell component="th" scope="row">
                                        {submission.IsPassed ? <CheckCircleOutlineIcon color="success"/> : <UnpublishedIcon color="error"/>}
                                    </TableCell>
                                    <TableCell >All tests</TableCell>
                                    <TableCell >{submission.Result.runningTime} ms</TableCell>
                                    <TableCell >{submission.Result.memoryUsed} mb</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </TableContainer>

                    <Divider className="my-4" />

                    <Typography variant="h5" gutterBottom>
                        Submission Details
                    </Typography>
                    <Divider className="my-4" />
                        <Paper elevation={0} className="p-2 bg-gray-100 rounded-lg">
                            <pre className="whitespace-pre-wrap">{submission.Code}</pre>
                        </Paper>
                </Paper>
            )}
        </DynamicLayout>
    );
}
