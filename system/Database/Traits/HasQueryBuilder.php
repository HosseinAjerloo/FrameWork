<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasQueryBuilder
{
    private $sql = '';
    private $where = [];
    private $orderBy = [];
    private $limit = [];
    private $values = [];
    private $bindValues = [];

    protected function setSql($sql)
    {
        $this->sql = $sql;
    }

    protected function getSql()
    {
        return $this->sql;
    }

    protected function resetSql()
    {
        $this->sql = '';
    }

    protected function setWhere($operator, $condition)
    {
        $where = ['operator' => $operator, 'condition' => $condition];
        array_push($this->where, $where);
    }

    protected function resetWhere()
    {
        $this->where = [];
    }

    protected function setOrderBy($name, $expression)
    {
        array_push($this->orderBy, $name . ' ' . $expression);
    }

    protected function resetOrderBy()
    {
        $this->orderBy = [];
    }

    protected function setLimit($limit, $offset)
    {
        $this->limit['limit'] = $limit;
        $this->limit['offset'] = $offset;
    }

    protected function resetLimit()
    {
        $this->limit = [];
    }

    protected function addValues($attribute, $value)
    {
        $this->values[$attribute] = $value;
        array_push($this->values, $value);
    }

    protected function resetValues()
    {
        $this->values = [];
        $this->bindValues = [];
    }

    protected function restQuery()
    {
        $this->resetSql();
        $this->resetWhere();
        $this->resetOrderBy();
        $this->resetLimit();
        $this->resetValues();
    }

    protected function queryBuilder()
    {
        $query = $this->getSql();
        if (!empty($this->where)) {
            $where = '';
            foreach ($this->where as $whereItem) {
                $where == '' ? $where .= $whereItem['condition'] : $where .= ' ' . $whereItem['operator'] . ' ' . $whereItem['condition'];
            }
            $query .= ' WHERE' . $where;
        }
        if (!empty($this->orderBy)) {
            $query .= ' ORDER BY ' . implode(',', $this->orderBy);
        }
        if (!empty($this->limit)) {
            $query .= ' LIMIT ' . $this->limit['limit'] . ' offset ' . $this->limit['offset'];
        }
        return $query;

    }

    protected function executeQuery()
    {
        $sql = $this->queryBuilder();
        $db = DBConnection::getInstanceDBConnection();
        $statement = $db->prepare($sql);
        if (sizeof($this->values) > sizeof($this->bindValues)) {
            $statement->execute(array_values($this->values));
        } elseif (sizeof($this->values) < sizeof($this->bindValues)) {
            $statement->execute($this->bindValues);
        } else
            $statement->execute();
        return $statement;
    }
    protected function getTableName()
    {
        return '`'.$this->table.'`';
    }
    protected function getAttributeName($attribute)
    {
        return $this->getTableName().'.'.'`'.$attribute.'`';
    }



}