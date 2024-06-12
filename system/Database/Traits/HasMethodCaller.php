<?php

namespace System\Database\Traits;
trait HasMethodCaller
{
    private $allMethod = ['get', 'save', 'all', 'create', 'update', 'where', 'whereNotNull', 'whereNull', 'whereIn', 'orderBy', 'limit', 'whereOr'
        , 'find', 'delete','first'];
    private $allowedMethod = ['get', 'save', 'all', 'create', 'update', 'where', 'whereNotNull', 'whereNull', 'whereIn', 'orderBy', 'limit', 'whereOr'
        , 'find', 'delete','first'];

    protected function setAllowedMethods($methodPermissions)
    {
        $this->allowedMethod = $methodPermissions;
    }

    private function methodCaller($object, $nameMethod, $argument)
    {
        $suffix = 'Method';
        if (in_array($nameMethod, $this->allowedMethod)) {
            $nameMethod .= $suffix;
            return call_user_func_array(array($object, $nameMethod), $argument);
        }
    }

    public function __call($name, $arguments)
    {
        return $this->methodCaller($this, $name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {

        $object = new(get_called_class());
        return $object->methodCaller($object, $name, $arguments);
    }
}