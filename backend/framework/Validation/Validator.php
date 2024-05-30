<?php

namespace Framework\Validation;

use Framework\Validation\Annotation\ValidationAttribute;

class Validator
{
    public static function isModelValid(object $model, array& $errors = []): bool{
        // take each property of the model

        $reflectionObject = new \ReflectionObject($model);
        $properties = $reflectionObject->getProperties();
        $isValid = true;
        foreach($properties as $property){
            $valid = self::isPropertyValid($property, $property->getValue($model), $errors);
            if($valid === false) $isValid = false;
        }

        return $isValid;
    }

    public static function isPropertyValid(\ReflectionProperty $property, $value, array& $errors = []): bool{
        $attributes = $property->getAttributes();
        foreach($attributes as $attribute){
            $instance = $attribute->newInstance();

            if($instance instanceof ValidationAttribute){
                $instance->validate($value, $property->getName());

                if(!$instance->isValid()){
                    $errors[] = $instance->getErrorMessage();
                    return false;
                }
            }
        }

        return true;
    }

    public static function getErrors(object $model): array{
        $err = [];
        self::isModelValid($model, $err);
        return $err;
    }
}