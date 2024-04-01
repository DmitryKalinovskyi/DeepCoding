<?php
/** @var Problem $problem */

use DeepCode\models\Problem;

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
    <div class="row" style="height: 500px">
        <div class="col-md-12 col-lg-6 h-100">
            <div class="bg-body-tertiary p-3 rounded-2 h-100">
                <div class="h4">
                    Problem name:  <?php echo $problem->Name?>
                </div>
                <div>
                    <?php echo $problem->Description?>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6  h-100 d-flex flex-column">
            <ul class="nav nav-tabs border-bottom-0 m-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="editor-tab" data-bs-toggle="tab" data-bs-target="#actual-editor-tab-page" type="button" role="tab" aria-controls="actual-editor-tab-page" aria-selected="true">Editor</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="submissions-tab" data-bs-toggle="tab" data-bs-target="#submissions-tab-page" type="button" role="tab" aria-controls="submissions-tab-page" aria-selected="false">Submissions</button>
                </li>
            </ul>
            <div class="bg-body-tertiary p-3 rounded-bottom-2 flex-grow-1">
                <div class="tab-content h-100" id="editor-tab-content">
                    <div class="tab-pane fade show active h-100" id="actual-editor-tab-page" role="tabpanel" >
                        <?php require_once 'partials/editor.php'; ?>
                    </div>
                    <div class="tab-pane fade h-100" id="submissions-tab-page" role="tabpanel" >
                        list of submissions...
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>


<?php include 'partials/footer.php'; ?>
</body>
</html>