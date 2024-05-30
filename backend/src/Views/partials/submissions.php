<?php

/** @var \DeepCode\Models\Problem\Problem $problem */

$userId = 1;

use DeepCode\Models\Problem\Problem;

?>

<div class="container" id="submissionContainer">

</div>

<script>

    let submissionContainer = document.querySelector('#submissionContainer');
    function render(submissions){
        console.log(submissions);

        let result = ""

        for(let submission of submissions){
            console.log(submission);

            result += `
                <div>
                    <div>Solution <a href="/api/submissions?id=${submission['Id']}">${submission['Id']}</a><div>
                </div>
            `
        }

        submissionContainer.innerHTML = result;
    }

    async function getSubmissions(){
        const url = `/api/submissions/problem?problemId=<?php echo $problem->Id?>&userId=<?php echo $userId?>`;

        console.log("Fetching... " + url);
        const response = await fetch(url);
        return await response.json();
    }

    getSubmissions().then(value => render(value));

</script>