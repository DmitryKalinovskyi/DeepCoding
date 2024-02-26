<?php

function write($var): void{
    echo $GLOBALS["_VIEW"][$var] ??  "<div class='text-light bg-danger p-2 rounded-2'>Variable with name \"$var\" is unset</div>";
}

function get($var): void
{
    echo $var ?? "VAR IS UNDEFINED";
}
