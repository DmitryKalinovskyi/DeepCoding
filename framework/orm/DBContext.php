<?php

namespace Framework\orm;

use PDO;

class DBContext
{
    private PDO $_pdo;
    public function __construct($connectionString){
        $this->_pdo = new PDO($connectionString, "root", "");
    }

    public function execute($query,){
        return $this->_pdo->query($query);
    }
}