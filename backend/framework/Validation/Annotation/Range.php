<?php

namespace Framework\Validation\Annotation;

use Attribute;

#[Attribute]
class Range extends ValidationAttribute
{
    private float $from;
    private float $to;
    public function __construct(float $from, float $to){
        $this->to = $to;
        $this->from = $from;

        if($from > $to)
            throw new \InvalidArgumentException("From should be less than to");
    }

    public function validate($value, $propertyName = "Value"): void
    {
        if(!is_numeric($value)){
            $this->setErrorMessage("$propertyName is not numeric");
            return;
        }

        if($this->from > $value){
            $this->setErrorMessage("$propertyName is less than $this->from");
            return;
        }

        if($this->to < $value){
            $this->setErrorMessage("$propertyName is greater than $this->to");
            return;
        }
    }
}