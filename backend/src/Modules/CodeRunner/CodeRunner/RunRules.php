<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class RunRules
{
    public string $code;

    public string $input;

    /** How much seconds I need to wait before interrupting process
     * @var float
     */
    public float $runtimeLimit;

    /** How many memory could be allocated
     * @var float
     */
    public float $memoryLimit;


    public function __construct(string $code = "", string $input = "", float $runtimeLimit = 5, float $memoryLimit = 255){
        $this->code = $code;
        $this->input = $input;
        $this->runtimeLimit = $runtimeLimit;
        $this->memoryLimit = $memoryLimit;
    }
}