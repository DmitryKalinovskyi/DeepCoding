import React, {useEffect, useState} from 'react';
import { Container, TextField, Button, Typography, Paper, CircularProgress, Alert, IconButton } from '@mui/material';
import { Add as AddIcon, Delete as DeleteIcon } from '@mui/icons-material';
import axios from "../../api/axios.ts";
import useAuth from "../../hooks/useAuth.ts";
import HTMLFrame from "../../shared/HTMLFrame.tsx";
import {useParams} from "react-router-dom";

interface Problem {
    Name: string;
    Description: string;
    TestingScript: string;
    TestingScriptLanguage: string;
    Tests: { name: string, input: string }[]; // Changed to array of objects
}

const ProblemEdit = () => {
    const { auth } = useAuth();
    const [problem, setProblem] = useState<Problem>({
        Name: "",
        Description: "",
        TestingScript: "",
        TestingScriptLanguage: "",
        Tests: [], // Initialize as empty array
    });
    const [isPosting, setIsPosting] = useState(false);
    const [error, setError] = useState("");
    const [isChanged, setIsChanged] = useState(true);
    const params = useParams<{problemId: string}>()
    async function fetchProblem(){
        const response = await axios.get(`api/problems/${params.problemId}`, {
            headers: {
                "Authorization": "Bearer " + auth.accessToken
            }
        });

        const data = response.data;
        data.Tests = JSON.parse(data.Tests);
        setProblem(data);
    }

    useEffect(() => {
        fetchProblem()
    }, []);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setProblem({
            ...problem,
            [name]: value,
        });
        setIsChanged(true);
    };

    const handleTestChange = (index: number, field: string, value: string) => {
        const updatedTests = problem.Tests.map((test, i) =>
            i === index ? { ...test, [field]: value } : test
        );
        setProblem({ ...problem, Tests: updatedTests });
        setIsChanged(true);
    };

    const addTest = () => {
        setProblem({
            ...problem,
            Tests: [...problem.Tests, { name: '', input: '' }]
        });
        setIsChanged(true);
    };

    const removeTest = (index: number) => {
        const updatedTests = problem.Tests.filter((_, i) => i !== index);
        setProblem({ ...problem, Tests: updatedTests });
        setIsChanged(true);
    };

    async function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
        e.preventDefault();
        try {
            const formData = new FormData(e.target as HTMLFormElement);
            const data = Object.fromEntries(formData.entries());
            data.Tests = JSON.stringify(problem.Tests); // Convert tests array to JSON string
            console.log(data);

            setIsPosting(true);
            await axios.patch(`api/problems/${params.problemId}`, data, {
                headers: {
                    "Authorization": "Bearer " + auth.accessToken
                }
            });
            setIsPosting(false);
            setIsChanged(false);
        } catch (err: any) {
            setIsPosting(false);

            if (err.response.status === 422) {
                setError(err.response.data.errors.toString());
            } else {
                console.log(err.message);
            }
        }
    }

    return (
        <div className="h-full">
            <Container maxWidth="md">
                <form method="post" onSubmit={handleSubmit}>
                    <Typography variant="h4" component="h1" gutterBottom>
                        Create Problem
                    </Typography>
                    <TextField
                        label="Name"
                        name="Name"
                        value={problem.Name}
                        onChange={handleChange}
                        fullWidth
                        required
                        margin="normal"
                    />
                    <TextField
                        label="Description"
                        name="Description"
                        value={problem.Description}
                        multiline
                        rows={10}
                        onChange={handleChange}
                        fullWidth
                        required
                        margin="normal"
                    />
                    <TextField
                        label="TestingScript"
                        name="TestingScript"
                        value={problem.TestingScript}
                        onChange={handleChange}
                        multiline
                        rows={10}
                        fullWidth
                        required
                        margin="normal"
                    />
                    <TextField
                        label="TestingScriptLanguage"
                        name="TestingScriptLanguage"
                        value={problem.TestingScriptLanguage}
                        onChange={handleChange}
                        fullWidth
                        required
                        margin="normal"
                    />
                    <Typography variant="h6" component="h2" gutterBottom>
                        Tests
                    </Typography>
                    {problem.Tests.map((test, index) => (
                        <Paper key={index} className="p-4 mb-4">
                            <TextField
                                label="Test Name"
                                value={test.name}
                                onChange={(e) => handleTestChange(index, 'name', e.target.value)}
                                fullWidth
                                required
                                margin="normal"
                            />
                            <TextField
                                label="Test Input"
                                value={test.input}
                                onChange={(e) => handleTestChange(index, 'input', e.target.value)}
                                fullWidth
                                multiline
                                margin="normal"
                            />
                            <IconButton onClick={() => removeTest(index)} aria-label="delete">
                                <DeleteIcon />
                            </IconButton>
                        </Paper>
                    ))}
                    <Button
                        variant="outlined"
                        color="primary"
                        className="mb-4"
                        onClick={addTest}
                        startIcon={<AddIcon />}
                        fullWidth
                    >
                        Add Test
                    </Button>
                    {isChanged ?
                        <Button
                            variant="contained"
                            color="primary"
                            type="submit"
                            disabled={isPosting}
                        >
                            {isPosting ? <CircularProgress size={24} /> : 'Submit'}
                        </Button>
                        : <Alert>Posted!</Alert>}

                    {error !== "" && <Alert severity="error">{error}</Alert>}

                    <Typography variant="h4" component="h1" gutterBottom className="mt-8">
                        Preview
                    </Typography>
                    <Paper className="p-4">
                        <Typography variant="h6" component="h3" gutterBottom>
                            {problem.Name}
                        </Typography>
                        <HTMLFrame srcDoc={problem.Description} />
                    </Paper>
                </form>
            </Container>
        </div>
    );
};

export default ProblemEdit;
