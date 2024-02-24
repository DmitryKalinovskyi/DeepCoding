<?php

function getDataFromFile($path): string{
    $file = fopen($path, 'r');

    $data = fread($file, filesize($path));

    fclose($file);

    return $data;
}