<?php


namespace DeepCode\models;

use Framework\attributes\Key;

class Problem
{
    #[Key]
    public int $Id;

    public string $Name;

    public string $Description;
}