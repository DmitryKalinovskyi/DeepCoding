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
    <form class="row mb-2">
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
    </form>

    <div>
        <table class="table">
            <tr>
                <th>
                    Status:
                </th>
                <th>
                    Name:
                </th>
            </tr>


            <?php
                function getStatusHTML($status):string{
                    if($status == 'solved'){
                        return "<i class='bi bi-check-circle text-activity'></i>";
                    }

                    if($status == "tried"){
                        return "<i class='bi bi-activity text-solved'></i>";
                    }

                    return "";
                }

                foreach($problems as $problem){
                    $id = $problem->Id;
                    $name = $problem->Name;
                    $desc = $problem->Description;

                    echo "
                    <tr>
                        <td>"
                            .GetStatusHTML('solved').
                        "</td>
                        <td>
                                <a href='problem?id=$id' class='link text-decoration-none'>
                                $name
                                </a>
                        </td>
                    </tr>
                    ";
                }
            ?>
        </table>

<!--        Old way of displaying problems-->
<!--        <ul class="list-group">-->
<!--            --><?php //foreach($problems as $problem){
//                $id = $problem->Id;
//                $name = $problem->Name;
//                $desc = $problem->Description;
//
//                echo "<li class=\"list-group-item\">
//                            <i class='bi bi-completed'></i>
//                            <div>
//                                <a href='problem?id=$id' class='link-dark text-decoration-none'>
//                                    $name
//                                </a>
//                            </div>
//                            </li>";
//            }
//
//            ?>
<!---->
<!--        </ul>-->
    </div>

    <nav class="d-flex justify-content-center mt-3" aria-label="...">
        <ul class="pagination">
            <?php

                for($i = 0; $i < $pageCount; $i++){
                    $active = $i == $page? 'active': '';

                    echo "<li class='page-item $active'><a class='page-link' href=\"problems?page=$i\">$i</a></li>";
                }
            ?>
        </ul>
    </nav>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>