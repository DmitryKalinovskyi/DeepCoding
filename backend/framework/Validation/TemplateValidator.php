<?php

namespace Framework\Validation;

use Framework\Validation\Annotation\ValidationAttribute;

class TemplateValidator
{
    public static function isModelValid(object $model, string $templateClass, bool $caseSensitive = false, array& $errors = []): bool{
        // take each property of the model
        $reflectionObject = new \ReflectionObject($model);
        $templateReflectionClass = new \ReflectionClass($templateClass);
        $properties = $reflectionObject->getProperties();
        $templateProperties = $templateReflectionClass->getProperties();
        $isValid = true;
        foreach($properties as $property){
            foreach($templateProperties as $templateProperty){
                // if properties names matches then try to validate
                $name1 = $property->getName();
                $name2 = $templateProperty->getName();

                if(!$caseSensitive){
                    $name1 = strtolower($name1);
                    $name2 = strtolower($name2);
                }

                if($name1 == $name2){
                    $valid = Validator::isPropertyValid($templateProperty,
                        $property->getValue($model), $errors);
                    if($valid === false) $isValid = false;
                }
            }
        }

        return $isValid;
    }

    public static function getErrors(object $model, string $templateClass, bool $caseSensitive = false): array{
        $err = [];
        self::isModelValid($model, $templateClass, $caseSensitive,$err);
        return $err;
    }
}