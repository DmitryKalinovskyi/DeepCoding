<?php

namespace Framework\Mapper;

use ReflectionObject;

class AutoMapper
{
    public static function map(object $from, object $to, bool $caseSensitive = false): void{
        $reflection = new ReflectionObject($from);
        $properties = $reflection->getProperties();

        foreach($properties as $property){
            $propertyName = $property->getName();

            self::mapProperty($propertyName, $from->$propertyName, $to, $caseSensitive);
        }
    }

    public static function mapFromArray(array $from, object $to, bool $caseSensitive = false): void{
        foreach($from as $propertyName => $value){
            self::mapProperty($propertyName, $value, $to, $caseSensitive);
        }
    }

    private static function mapProperty(string $propertyName, $value, object $to, bool $caseSensitive = false): void{
        if($caseSensitive){
            if(property_exists($to, $propertyName)){
                $to->$propertyName = $value;
            }
        }
        else{
            $propertyName = strtolower($propertyName);
            $reflectionObject = new ReflectionObject($to);
            $toProperties = $reflectionObject->getProperties();
            foreach($toProperties as $toProperty){
                if($propertyName === strtolower($toProperty->getName())){
                    $toProperty->setValue($to, $value);
                }
            }
        }
    }
}