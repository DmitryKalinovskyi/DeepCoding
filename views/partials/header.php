<?php


function SelectedPageStyle($linkName): string{
    return $linkName != pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME)? "link-body-emphasis": "link-secondary";
}

$USERID = 10;

?>

<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/index.php"><img width="150px" height="60px" src="/public/img/logo.jpg"></a></li>
                <li class="d-flex align-items-center"><a href="/views/problems.php" class="nav-link  px-2 <?php echo SelectedPageStyle("problems")?> ">Problems</a></li>
                <li class="d-flex align-items-center"><a href="/views/competitions.php" class="nav-link px-2 <?php echo SelectedPageStyle("competitions")?>">Competitions</a></li>
                <li class="d-flex align-items-center"><a href="/views/bestcoders.php" class="nav-link px-2 <?php echo SelectedPageStyle("bestcoders")?>">Best Coders</a></li>
                <li class="d-flex align-items-center"><a href="/views/roadmaps.php" class="nav-link px-2 <?php echo SelectedPageStyle("roadmaps")?>">Roadmaps</a></li>
            </ul>

            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small" style="">
                    <li><a class="dropdown-item" href="/views/profile.php?id=<?php echo $USERID?>">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
