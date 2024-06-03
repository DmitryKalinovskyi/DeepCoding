<?php

namespace DeepCode\Modules\Problems\DTO;

class ProblemDTO
{
    public int $Id;

    public string $Name;

    public string $Description;

    public string $TestingScript;

    public string $TestingScriptLanguage;

    public string $Status;

    public array $Tags;

    public string $Difficulty;
}