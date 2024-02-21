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

    <!--plotly-->
    <script src='https://cdn.plot.ly/plotly-2.29.1.min.js'></script>
    <script src="/scripts/ratingChart.js" defer></script>
    <title>Document</title>
</head>
<body>
<?php
include 'partials/header.php';

function GetStars($count): string{
//    return str_repeat("<span class=\"bi bi-star\"></span>", $count);
    return str_repeat("<img height='24px' width='24px' src='/public/img/star.png'>", $count);
}


$USER_TITLE = "RED"
?>

<div class="container">
    <div class="row gx-5">
        <div class="col-4">
            <div class="bg-body-tertiary p-3 rounded-2 shadow-sm">
                <img width="64px" height="64px" class="rounded-2" alt='avatar' src="/public/img/testAvatar.png">
                <div class="h3">
                    Dmytro Kalinovskyi
                </div>
                <div>
                    DeeperXD <span class="badge text-bg-danger"><?php echo $USER_TITLE ?></span>
                </div>

                <div>
                    <span class="badge text-bg-secondary">Rank:</span> <span class="badge text-bg-danger">1</span>
                </div>

                <div>
                    hello there!
                </div>
                <hr>
                <div>
                    ...
                </div>
            </div>

        </div>
        <div class="col-8">
            <div class="row gy-4">
                <div class="col12 bg-body-tertiary p-3 rounded-2 shadow-sm">
                    <div class="row">
                        <div class="col-6">
                            <div class="m-0" id='ratingChart' ></div>
                        </div>
                        <div class="col-6">
                            <div>
                                Solved Problems
                            </div>
                            <div>
                                <div><?php echo GetStars(1)?></div>
                                <div><?php echo GetStars(2)?></div>
                                <div><?php echo GetStars(3)?></div>
                                <div><?php echo GetStars(4)?></div>
                                <div><?php echo GetStars(5)?></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col12 bg-body-tertiary p-3 rounded-2 shadow-sm">
                    <div>
                        Activity
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
include 'partials/footer.php';
?>
</body>
</html>