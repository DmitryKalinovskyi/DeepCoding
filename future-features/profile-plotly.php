<?php

function GetStars($count): string{
//    return str_repeat("<span class=\"bi bi-star\"></span>", $count);
    return str_repeat("<img height='24px' width='24px' src='/public/img/star.png'>", $count);
}


?>


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