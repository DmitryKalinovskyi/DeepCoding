<?php

include_once "../utils/filehelper.php";


if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['id']) === false) {
        header('Location: problems.php');
        exit();
    }
}

// load problem data
function getProblemData(): array{
    $problem_id = 1;

    $path = '../data/problems/' . $problem_id;
    return ["name" => getDataFromFile($path."/name.txt"),
        "description" => getDataFromFile($path.'/description.txt')];
}

$problem = getProblemData();

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    include 'partials/styleincludes.php'
    ?>

    <title>Document</title>
</head>
<body>
<?php include 'partials/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="bg-body-tertiary p-3 rounded-2 shadow-sm">
                <div class="h4">
                    Problem name:  <?php echo $problem["name"]?>
                </div>
                <div>
                    <?php echo $problem["description"]?>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="bg-body-tertiary p-3 rounded-2 shadow-sm">
                <?php require_once 'partials/editor.php'; ?>
            </div>
        </div>
    </div>


</div>


<?php include 'partials/footer.php'; ?>
</body>
</html>