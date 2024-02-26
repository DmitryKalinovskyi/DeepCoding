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
                            <div>
                                <a href='problem?id=$i'>
                                    Task {$i}
                                </a>
                            
                            </div>
                            </li>";
                }
            ?>
        </ul>
    </div>

    <nav class="d-flex justify-content-center mt-3" aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>