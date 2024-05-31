<?php

namespace DeepCode\DB;

use DeepCode\Models\News;
use DeepCode\Models\Problem\Problem;
use DeepCode\Models\Role;
use DeepCode\Models\Submission;
use DeepCode\Models\User;
use DeepCode\Models\User_Role;
use Framework\ORM\DBContext;
use Framework\ORM\DBSet;

class DeepCodeContext extends DBContext
{
    public DBSet $users;
    public const USERS_TABLE = "users";


    public DBSet $problems;
    public const PROBLEMS_TABLE = "problems";

    public DBSet $submissions;
    public const SUBMISSIONS_TABLE = "submissions";

    public DBSet $roles;
    public const ROLES_TABLE = "roles";

    public DBSet $user_roles;
    public const USER_ROLES_TABLE = "user_roles";

    public DBSet $news;
    public const NEWS_TABLE = "news";

    public function __construct($connectionString)
    {
        parent::__construct($connectionString);
        $this->users = new DBSet(self::USERS_TABLE, User::class, $this);
        $this->problems = new DBSet(self::PROBLEMS_TABLE, Problem::class, $this);
        $this->submissions = new DBSet(self::SUBMISSIONS_TABLE, Submission::class, $this);
        $this->roles = new DBSet(self::ROLES_TABLE, Role::class, $this);
        $this->user_roles = new DBSet(self::USER_ROLES_TABLE, User_Role::class, $this);
        $this->news = new DBSet(self::NEWS_TABLE, News::class, $this);
    }
}