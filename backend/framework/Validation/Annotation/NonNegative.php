<?php

namespace Framework\Validation\Annotation;

#[\Attribute]
class NonNegative extends ValidationAttribute
{

    public function validate($value, string $propertyName = "Value"): void
    {
        // Check if the value is a non-negative integer or a numeric string representing a non-negative integer
        if (!is_numeric($value) || $value < 0 || intval($value) != $value) {
            $this->setErrorMessage("$propertyName must be a non-negative number.");
        }
    }
}