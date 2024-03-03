<?php

namespace DeepCode\db;

use DeepCode\models\PlatformUser;
use DeepCode\models\Problem;
use Framework\orm\DBContext;
use Framework\orm\DBSet;

class DeepCodeContext extends DBContext
{
    public DBSet $problems;
    public DBSet $platformUsers;

    public function __construct($connectionString)
    {
        parent::__construct($connectionString);

        $this->problems = new DBSet(Problem::class, $this);
        $this->platformUsers = new DBSet(PlatformUser::class, $this);
    }
}