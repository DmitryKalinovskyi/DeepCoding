<?php

function write($var): void{
    var_dump(get_defined_vars());

    echo $$var ??  "<div class='text-light bg-danger p-2 rounded-2'>Variable with name \"$var\" is unset</div>";
}