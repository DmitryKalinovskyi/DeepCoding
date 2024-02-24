<?php

function getDataFromFile($path): string{
    $file = fopen($path, 'r');

    $data = fread($path, filesize($path));

    fclose($file);

    return $data;
}