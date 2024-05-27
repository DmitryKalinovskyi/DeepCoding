<?php

namespace Framework\ORM;

use Framework\ORM\Queries\DeleteQuery;
use Framework\ORM\Queries\SelectQuery;
use Framework\ORM\Queries\UpdateQuery;

class DBSet
{
    private string $_tableName;
    private string $_className;
    private string $_tableAlias;
    private DBContext $_dbContext;

    public function __construct($tableName, $className, $dbContext){
        $this->_tableName = $tableName;
        $this->_className = $className;
        $this->_dbContext = $dbContext;
    }

    public function alias(string $alias): self{
        $this->_tableAlias = $alias;
        return $this;
    }

    private function getTableName(): string{
        if(!empty($this->_tableAlias)){
            return "$this->_tableName as $this->_tableAlias";
        }
        return $this->_tableName;
    }

    public function insert(object $value): array|false{
        // get columns from the class using reflection, then specify them inside query.

        $proxy = $this->_dbContext->query()->insert()
            ->into($this->_tableName);

        $data = (array)$value;

        $cols = [];
        $values = [];

        foreach($data as $key => $value){
            $cols[] = $key;
            $values[] = $value;
        }

        $proxy->columns($cols);

        return $proxy->execute($values);
    }

    public function select(array $columns = ['*']): SelectQuery
    {
        $proxy = $this->_dbContext->query();
        $proxySelect = $proxy->select($columns);

        $proxySelect->from($this->getTableName());
        $proxySelect->asClass($this->_className);

        return $proxySelect;
    }

    public function update(): UpdateQuery
    {
        $proxy = $this->_dbContext->query();
        return $proxy->update([$this->getTableName()]);
    }

    public function delete(): DeleteQuery
    {
        $proxy = $this->_dbContext->query();
        $proxyDelete = $proxy->delete();
        $proxyDelete->from($this->getTableName());

        return $proxyDelete;
    }

    public function count(): int{
        $qb = $this->_dbContext->query()
            ->select(["COUNT(*) as __DBSET__count"])
            ->from($this->getTableName());

        return $qb->execute()[0]['__DBSET__count'];
    }
}