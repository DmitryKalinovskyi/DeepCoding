<?php

namespace DeepCode\Models;

use DateTime;

class News
{
    public int $Id;

    public string $Title;

    public string $Content;

    public string $Preview;

    public int $CreatedTime;
}