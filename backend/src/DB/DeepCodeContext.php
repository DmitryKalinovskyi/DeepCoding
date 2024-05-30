<?php

namespace DeepCode\DB;

use DeepCode\Models\Problem\Problem;
use DeepCode\Models\Submission;
use DeepCode\Models\User;
use Framework\ORM\DBContext;
use Framework\ORM\DBSet;

class DeepCodeContext extends DBContext
{
    public DBSet $platformUsers;
    public DBSet $problems;

    public DBSet $submissions;

    public const USERS_TABLE = "users";
    public const PROBLEMS_TABLE = "problems";
    public const SUBMISSIONS_TABLE = "submissions";

    public function __construct($connectionString)
    {
        parent::__construct($connectionString);
        $this->platformUsers = new DBSet(self::USERS_TABLE, User::class, $this);
        $this->problems = new DBSet(self::PROBLEMS_TABLE, Problem::class, $this);
        $this->submissions = new DBSet(self::SUBMISSIONS_TABLE, Submission::class, $this);
    }
}