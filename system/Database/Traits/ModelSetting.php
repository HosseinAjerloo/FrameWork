<?php

namespace System\Database\Traits;

trait ModelSetting
{
    public function __construct()
    {
        $this->table==null?$this->table=$this->defaultTableName():null;

        echo $this->primaryKey;
    }

    protected function defaultTableName()
    {
        return  strtolower((new \ReflectionClass(get_called_class()))->getShortName()).'s';
    }
}