<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Document</title>
</head>
<body>
<?php include 'partials/header.php'; ?>

<div class="container">
    <form class="row">
        <div class="col-2">
            <select class="form-select">
                <option>All</option>
                <option>Easy</option>
                <option>Medium</option>
                <option>Hard</option>
            </select>
        </div>
        <div class="col-2">
            <select class="form-select">
                <option>None</option>
                <option>Tag1</option>
                <option>Tag2</option>
                <option>Tag3</option>
            </select>
        </div>

        <div class="col-2">
            <select class="form-select">
                <option>All</option>
                <option>Not even tried</option>
                <option>Tried</option>
                <option>Solved</option>
            </select>
        </div>
        <div class="col-6">

        <div class="input-group">
            <span class="input-group-text bi bi-search"></span>
            <input class="form-control" placeholder="Enter problem name">
        </div>
        </div>
    </form>'

    <div>
        <ul class="list-group">
            <?php
                for($i = 0; $i < 10; $i++){
                    echo "<li class=\"list-group-item\">
                            <i class='bi bi-completed'></i>
                            <div>Task {$i}</div>
                            </li>";
                }
            ?>
        </ul>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>