<?php

namespace DeepCode\DB;

use DeepCode\Models\PlatformUser;
use DeepCode\Models\Problem;
use DeepCode\Models\Submission;
use Framework\ORM\DBContext;
use Framework\ORM\DBSet;

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