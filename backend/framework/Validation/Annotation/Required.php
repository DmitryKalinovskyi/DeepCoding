<?php

namespace Framework\Validation\Annotation;

#[\Attribute]
class Required extends ValidationAttribute
{
    private string $defaultErrorMessage = "";

    public function __construct(string $errorMessage = ""){
        $this->defaultErrorMessage = $errorMessage;
    }

    public function validate($value, string $propertyName = "Value"): void
    {
        if($value == null){
            if(empty($this->defaultErrorMessage))
                $this->defaultErrorMessage = "$propertyName is null";
            $this->setErrorMessage($this->defaultErrorMessage);
        }
    }
}