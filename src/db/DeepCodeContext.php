<?php

namespace DeepCode\db;

use DeepCode\models\PlatformUser;
use DeepCode\models\Problem;
use Framework\orm\DBContext;
use Framework\orm\DBSet;

class DeepCodeContext extends DBContext
{
    public DBSet $platformUsers;
    public DBSet $problems;

    public function __construct($connectionString)
    {
        parent::__construct($connectionString);
        $this->platformUsers = new DBSet("platformusers", PlatformUser::class, $this);
        $this->problems = new DBSet("problems", Problem::class, $this);
    }
}