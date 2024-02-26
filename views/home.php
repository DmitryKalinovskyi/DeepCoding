<?php require_once "partials/viewbase.php" ?>

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
    <?php
    var_dump(get_defined_vars());
    write("msg") ?>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>