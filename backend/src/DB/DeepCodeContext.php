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

    public const PLATFORM_USERS_TABLE = "platformusers";
    public const PROBLEMS_TABLE = "problems";
    public const SUBMISSIONS_TABLE = "submissions";


    public function __construct($connectionString)
    {
        parent::__construct($connectionString);
        $this->platformUsers = new DBSet(self::PLATFORM_USERS_TABLE, PlatformUser::class, $this);
        $this->problems = new DBSet(self::PROBLEMS_TABLE, Problem::class, $this);
        $this->submissions = new DBSet(self::SUBMISSIONS_TABLE, Submission::class, $this);
    }
}