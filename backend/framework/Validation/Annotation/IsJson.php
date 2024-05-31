<?php

namespace Framework\Validation\Annotation;

use InvalidArgumentException;

#[\Attribute]
class IsJson extends ValidationAttribute
{
    public function validate($value, string $propertyName = "Value"): void
    {
        // Check if the value is a string
        if (!is_string($value)) {
            $this->setErrorMessage("{$propertyName} must be a string.");
            return;
        }

        // Attempt to decode the JSON string
        $decodedValue = json_decode($value);

        // Check if the decoded value is null and the input is not the JSON representation of null
        if ($decodedValue === null && strtolower(trim($value)) !== 'null') {
            $this->setErrorMessage("{$propertyName} must be a valid JSON string.");
            return;
        }
    }
}