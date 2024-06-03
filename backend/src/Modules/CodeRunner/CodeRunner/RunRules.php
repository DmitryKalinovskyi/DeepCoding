<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class RunRules
{
    public string $Code;


    /** How much seconds I need to wait before interrupting process
     * @var float
     */
    public float $TimeLimit;

    /** How many memory could be allocated
     * @var float
     */
    public float $MemoryLimit;

    public string $Input;
}