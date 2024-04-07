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

    <!--plotly-->
<!--    <script src='https://cdn.plot.ly/plotly-2.29.1.min.js'></script>-->
<!--    <script src="/scripts/ratingChart.js" defer></script>-->
    <title>Document</title>
</head>
<body>
<?php
include 'partials/header.php';

$USER_TITLE = "RED"
?>

<div class="container mt-4">
    <div class="row gx-5">
        <div class="col-4">
            <div class="bg-body-tertiary p-3 rounded-2 shadow-sm">
                <img width="64px" height="64px" class="rounded-2" alt='avatar' src="<?php echo $profile->AvatarUrl ?>">
                <div class="h3">
                    <?php echo $profile->GetFullName() ?>
                </div>
                <div>
                    <?php echo $profile->Login ?>
                    <span class="badge text-bg-danger"><?php echo $USER_TITLE ?></span>
                </div>

                <div>
                    <span class="badge text-bg-secondary">Rank:</span> <span class="badge text-bg-danger">1</span>
                </div>

                <div>
                    <?php echo $profile->Description ?>
                </div>
                <hr>
                <div>
                    ...
                </div>
            </div>

        </div>
        <div class="col-8">
            <div class="row gy-4">

                <div class="col-12 bg-body-tertiary p-3 rounded-2 shadow-sm">
                    <div>
                        Activity
                    </div>
                    <div>
                        here will be github styled day by day amount of submissions
                    </div>
                </div>
                <div class="col12 bg-body-tertiary p-3 rounded-2 shadow-sm">
                    <div>
                        Last submissions
                    </div>
                    <div>
                        <?php

                        echo "<ul class='list-group'>";
                        for($i = 0; $i < 10; $i++){
                            echo "<li class='list-group-item'> Task {$i}</li>";
                        }
                        echo "</ul>";
                        ?>
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