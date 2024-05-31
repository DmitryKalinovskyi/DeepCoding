<?php

namespace Framework\Mapper;

use Error;
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
                try{
                    $toProperty->setValue($to, $value);
                }catch(Error $e){
                    throw new \Exception("$propertyName should be of type " . $toProperty->getType()->getName());
                }
            }
        }
    }

    /** Return object with properties that are common in both $from and $frame. Values of that object is taken from $from
     *
     * @param object $from
     * @param object $frame
     * @param bool $caseSensitive
     * @return object
     */
    public static function intersect(object $from, object $frame, bool $caseSensitive = false): object{
        $reflectionA = new ReflectionObject($from);
        $reflectionB = new ReflectionObject($frame);

        $propertiesA = $reflectionA->getProperties();
        $propertiesB = $reflectionB->getProperties();

        $propertiesANames = [];
        $propertiesBNames = [];
        foreach($propertiesA as $property)
            $propertiesANames[] = $caseSensitive ? $property->getName(): strtolower( $property->getName());

        foreach($propertiesB as $property)
            $propertiesBNames[] = $caseSensitive ? $property->getName(): strtolower( $property->getName());

        // take intersection
        $props = array_intersect($propertiesANames, $propertiesBNames);

        $intersectResult = [];
        foreach($propertiesA as $property){
            $name = $property->getName();
            if(!$caseSensitive) $name = strtolower($name);

            if(in_array($name ,$props))
                $intersectResult[$property->getName()] = $property->getValue($from);
        }

        return (object)$intersectResult;
    }
}