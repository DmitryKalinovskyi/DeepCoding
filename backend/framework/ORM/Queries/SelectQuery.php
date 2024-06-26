<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\ISelectQueryBuilder;

class SelectQuery implements ISelectQueryBuilder, IDBExecutable
{
    private ISelectQueryBuilder $_selectQueryBuilder;
    private DBContext $_dbContext;

    private array $params = [];

    public function __construct(ISelectQueryBuilder $selectQueryBuilder, DBContext $dbContext){
        $this->_selectQueryBuilder = $selectQueryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function select(array $columnNames): self
    {
        $this->_selectQueryBuilder->select($columnNames);
        return $this;
    }

    public function from(string $source): self
    {
        $this->_selectQueryBuilder->from($source);
        return $this;
    }

    public function fromSources(array $sources): self
    {
        $this->_selectQueryBuilder->fromSources($sources);
        return $this;
    }

    public function where($condition): self
    {
        $this->_selectQueryBuilder->where($condition);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->_selectQueryBuilder->limit($limit);
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->_selectQueryBuilder->offset($offset);
        return $this;
    }

    public function build(): string
    {
        return $this->_selectQueryBuilder->build();
    }

    public function clone(): self
    {
        $clone = new SelectQuery($this->_selectQueryBuilder->clone(), $this->_dbContext);
        $clone->_selectAs = $this->_selectAs;
        $clone->_select_class = $this->_select_class;
        $clone->params = $this->params;
        return $clone;
    }

    private const ARRAY_TYPE = "array";
    private const OBJECT_TYPE = "object";
    private const CLASS_TYPE = "class";

    private string $_selectAs = self::ARRAY_TYPE;
    private string $_select_class = "";

    public function asClass($class): self{
        $this->_selectAs = self::CLASS_TYPE;
        $this->_select_class = $class;
        return $this;
    }

    public function asObject(): self{
        $this->_selectAs = self::OBJECT_TYPE;
        return $this;
    }

    // used by default
    public function asArray(): self{
        $this->_selectAs = self::ARRAY_TYPE;
        return $this;
    }

    public function execute($params = []): array|false
    {
        $params = array_merge($this->params, $params);

        if($this->_selectAs == self::ARRAY_TYPE)
            return $this->_dbContext->execute($this->build(), $params);
        else if($this->_selectAs == self::OBJECT_TYPE)
            return $this->_dbContext->execute($this->build(), $params, true);
        else if($this->_selectAs == self::CLASS_TYPE)
            return $this->_dbContext->execute($this->build(), $params, true, $this->_select_class);

        return false;
    }

    public function first($params = []): mixed{

        $clone = $this->clone();
        $clone->limit(1);

        $result = $clone->execute($params);

        if(empty($result[0])) return null;

        return $result[0];
    }

    public function orderBy(string $columnName, bool $isAscending = true): self
    {
        $this->_selectQueryBuilder->orderBy($columnName, $isAscending);
        return $this;
    }

    public function orderByColumns(array $columnNames, bool $isAscending = true): self
    {
        $this->_selectQueryBuilder->orderByColumns($columnNames, $isAscending);
        return $this;
    }

    public function clearOrderBy(): self
    {
        $this->_selectQueryBuilder->clearOrderBy();
        return $this;
    }

    public function innerJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->innerJoin($tableName, $on);
        return $this;
    }

    public function leftJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->leftJoin($tableName, $on);
        return $this;
    }

    public function rightJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->rightJoin($tableName, $on);
        return $this;
    }

    public function fullJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->fullJoin($tableName, $on);
        return $this;
    }

    public function groupBy(array $columnNames): self
    {
        $this->_selectQueryBuilder->groupBy($columnNames);
        return $this;
    }

    public function having(string $condition): self
    {
        $this->_selectQueryBuilder->having($condition);
        return $this;
    }

    public function useParams(array $params): SelectQuery
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function count(): int{
        // consider that we built some query, and we want to receive count of that select
        // we just wrap it with another query.

        $clone = $this->clone();
        $query = $clone->build();
        $params = $clone->params;

        $fullQuery = $this->_dbContext->query()->select(["COUNT(*) as __COUNT__"])
            ->from("(" . $query . ") as __COUNT_ALIAS__")->build();

        $executeResult = $this->_dbContext->execute($fullQuery, $params);

        if(empty($executeResult)) return 0;

        $val = $executeResult[0]["__COUNT__"];
        return $val;
    }

}