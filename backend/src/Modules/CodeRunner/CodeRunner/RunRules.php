<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class RunRules
{

    /**
     * @var array Files that will be added to container, array format [File Name => File Content], code.txt is required.
     */
    public array $files;

    /** How much seconds I need to wait before interrupting process
     * @var float
     */
    public float $runtimeLimit;

    /** How many memory could be allocated
     * @var float
     */
    public float $memoryLimit;


    public function __construct(array $files = [], float $runtimeLimit = 5, float $memoryLimit = 255){
        $this->files = $files;
        $this->runtimeLimit = $runtimeLimit;
        $this->memoryLimit = $memoryLimit;
    }
}