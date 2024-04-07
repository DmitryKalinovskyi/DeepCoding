<?php

namespace DeepCode\db;

use DeepCode\models\PlatformUser;
use DeepCode\models\Problem;
use DeepCode\models\Submission;
use Framework\orm\DBContext;
use Framework\orm\DBSet;

class DeepCodeContext extends DBContext
{
    public DBSet $platformUsers;
    public DBSet $problems;
    public DBSet $submissions;

    public function __construct($connectionString)
    {
        parent::__construct($connectionString);
        $this->platformUsers = new DBSet("platformusers", PlatformUser::class, $this);
        $this->problems = new DBSet("problems", Problem::class, $this);
        $this->submissions = new DBSet("submissions", Submission::class, $this);
    }
}