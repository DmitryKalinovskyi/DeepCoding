<?php require_once 'partials/viewbase.php'?>


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
                    Problem name:  <?php echo $problem->Name?>
                </div>
                <div>
                    <?php echo $problem->Description?>
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