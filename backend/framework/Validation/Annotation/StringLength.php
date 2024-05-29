<?php

namespace Framework\Validation\Annotation;

use Attribute;

#[Attribute]
class StringLength extends ValidationAttribute
{
    private int $minLength;
    private ?int $maxLength;

    public function __construct(int $minLength, ?int $maxLength = null)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;

        if ($maxLength !== null && $minLength > $maxLength) {
            throw new \InvalidArgumentException("Minimum length cannot be greater than maximum length");
        }
    }

    public function validate($value, string $propertyName = "Value"): void
    {
        $length = strlen($value);

        if ($length < $this->minLength) {
            $this->setErrorMessage("$propertyName must be at least {$this->minLength} characters long");
            return;
        }

        if ($this->maxLength !== null && $length > $this->maxLength) {
            $this->setErrorMessage("$propertyName cannot be longer than {$this->maxLength} characters");
            return;
        }
    }
}
