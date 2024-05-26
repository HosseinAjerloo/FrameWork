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
        $this->sql='';
    }

}