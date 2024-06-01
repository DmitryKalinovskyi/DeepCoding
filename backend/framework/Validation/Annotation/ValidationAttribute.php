<?php

namespace Framework\Validation\Annotation;


abstract class ValidationAttribute
{
    private bool $isValid = true;
    private string $errorMessage = "";


    /** Make validation of the value, in case of error, sets the error message
     * @param $value
     * @param string $propertyName
     * @return void
     */
    public abstract function validate($value, string $propertyName = "Value"): void;

    /** Checks whether object is valid, should be invoked after is validated
     * @return bool is valid or not
     */
    public function isValid(): bool{
        return $this->isValid;
    }


    /** Returns error message in case of validation failed
     * @return string error message
     */
    public function getErrorMessage(): string{
        return $this->errorMessage;
    }

    protected function setErrorMessage(string $message): void{
        $this->isValid = false;
        $this->errorMessage = $message;
    }

    protected function addErrorMessage(string $message): void{
        $this->isValid = false;
        $this->errorMessage .= $message;
    }
}