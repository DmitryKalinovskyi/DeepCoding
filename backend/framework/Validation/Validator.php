<?php

namespace Framework\Validation;

use Framework\Validation\Annotation\ValidationAttribute;

class Validator
{
    public static function isModelValid(object $model, string& $errorMessage = ""): bool{
        // take each property of the model

        $reflectionObject = new \ReflectionObject($model);
        $properties = $reflectionObject->getProperties();
        $isValid = true;
        foreach($properties as $property){
            $valid = self::isPropertyValid($property, $property->getValue($model), $errorMessage);
            if($valid === false) $isValid = false;
        }

        return $isValid;
    }

    public static function isPropertyValid(\ReflectionProperty $property, $value, string& $errorMessage = ""): bool{
        $attributes = $property->getAttributes();
        foreach($attributes as $attribute){
            $instance = $attribute->newInstance();

            if($instance instanceof ValidationAttribute){
                $instance->validate($value, $property->getName());

                if(!$instance->isValid()){
                    $errorMessage .= $instance->getErrorMessage() . PHP_EOL;
                    return false;
                }
            }
        }

        return true;
    }

    public static function getErrorMessage(object $model): string{
        $err = "";
        self::isModelValid($model, $err);
        return $err;
    }
}