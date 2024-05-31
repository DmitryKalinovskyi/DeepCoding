<?php

namespace Framework\Mapper;

use Framework\Attributes\Mapping\IgnoreMapper;
use ReflectionObject;

class AutoMapper
{
    public static function map(object $from, object $to, bool $caseSensitive = false): object{
        $reflection = new ReflectionObject($from);
        $properties = $reflection->getProperties();

        foreach($properties as $property){
            $propertyName = $property->getName();

            self::mapProperty($propertyName, $from->$propertyName, $to, $caseSensitive);
        }
        return $to;
    }

    public static function mapFromArray(array $from, object $to, bool $caseSensitive = false): object{
        foreach($from as $propertyName => $value){
            self::mapProperty($propertyName, $value, $to, $caseSensitive);
        }

        return $to;
    }

    // TODO: speed up mapping using only one for loop
    private static function mapProperty(string $propertyName, $value, object $to, bool $caseSensitive = false): void{
        $reflectionObject = new ReflectionObject($to);
        $toProperties = $reflectionObject->getProperties();
        foreach($toProperties as $toProperty){
            // if it's ignored we don't map
            $attributes = $toProperty->getAttributes();

            $ignore = false;
            foreach($attributes as $attribute){
                $instance = $attribute->newInstance();

                if($instance instanceof IgnoreMapper) $ignore = true;
            }

            if($ignore) continue;

            $toPropertyName = $toProperty->getName();

            if(!$caseSensitive){
                $propertyName = strtolower($propertyName);
                $toPropertyName = strtolower($toPropertyName);
            }

            if($propertyName === $toPropertyName){
                $toProperty->setValue($to, $value);
            }
        }
    }
}