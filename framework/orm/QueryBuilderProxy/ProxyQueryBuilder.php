<?php

namespace Framework\orm\QueryBuilderProxy;

use Framework\orm\DBContext;
use Framework\orm\QueryBuilder\IDeleteQueryBuilder;
use Framework\orm\QueryBuilder\IQueryBuilder;
use Framework\orm\QueryBuilder\ISelectQueryBuilder;
use Framework\orm\QueryBuilder\IUpdateQueryBuilder;

class ProxyQueryBuilder implements IQueryBuilder
{
    private ISelectQueryBuilder $_selectService;
    private IUpdateQueryBuilder $_updateService;
    private IDeleteQueryBuilder $_deleteService;

    private DBContext $_dbContext;

    // initialize with default query builder services
    public function __construct(ISelectQueryBuilder $selectService,
                                IUpdateQueryBuilder $updateService,
                                IDeleteQueryBuilder $deleteService,
                                DBContext $dbContext
    ){
        $this->_selectService = $selectService;
        $this->_updateService = $updateService;
        $this->_deleteService = $deleteService;
        $this->_dbContext = $dbContext;
    }

    public function select(array $columns): ProxySelect
    {
        $proxySelect = new ProxySelect($this->_selectService, $this->_dbContext);
        $proxySelect->select($columns);

        return $proxySelect;
    }

    public function update(array $tables): ProxyUpdate
    {
        $proxyUpdate = new ProxyUpdate($this->_updateService, $this->_dbContext);
        $proxyUpdate->update($tables);

        return $proxyUpdate;
    }

    public function delete(): ProxyDelete
    {
        return new ProxyDelete($this->_deleteService, $this->_dbContext);
    }
}