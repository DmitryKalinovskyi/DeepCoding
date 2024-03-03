<?php

namespace Framework\utils;

class NamingUtils{
    public static function getTableByClassname($className){
        $parts = explode("\\", $className);
        return strtolower(end($parts)) . "s";
    }
}
