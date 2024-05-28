<?php

namespace Framework\Mapper;

use ReflectionObject;

class AutoMapper
{
    public static function map(object $from, object $to): void{
        $reflection = new ReflectionObject($from);
        $properties = $reflection->getProperties();

        foreach($properties as $property){
            $propertyName = $property->getName();
            if(property_exists($to, $propertyName) && $from->$propertyName){
                $to->$propertyName = $from->$propertyName;
            }
        }
    }
}