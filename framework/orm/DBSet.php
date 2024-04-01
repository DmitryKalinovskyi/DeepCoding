<?php

namespace Framework\orm;

use Framework\orm\QueryBuilderProxy\ProxyDelete;
use Framework\orm\QueryBuilderProxy\ProxySelect;
use Framework\orm\QueryBuilderProxy\ProxyUpdate;

class DBSet
{
    private string $_tableName;
    private string $_className;
    private DBContext $_dbContext;

    public function __construct($tableName, $className, $dbContext){
        $this->_tableName = $tableName;
        $this->_className = $className;
        $this->_dbContext = $dbContext;
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

    public function select(array $columns = ['*']): ProxySelect
    {
        $proxy = $this->_dbContext->query();
        $proxySelect = $proxy->select($columns);

        $proxySelect->from($this->_tableName);
        $proxySelect->asClass($this->_className);

        return $proxySelect;
    }

    public function update(): ProxyUpdate
    {
        $proxy = $this->_dbContext->query();
        return $proxy->update([$this->_tableName]);
    }

    public function delete(): ProxyDelete
    {
        $proxy = $this->_dbContext->query();
        $proxyDelete = $proxy->delete();
        $proxyDelete->from($this->_tableName);

        return $proxyDelete;
    }

    public function count(): int{
        $qb = $this->_dbContext->query()
            ->select(["COUNT(*) as count"])
            ->from($this->_tableName);

        return $qb->execute()[0]['count'];
    }
}