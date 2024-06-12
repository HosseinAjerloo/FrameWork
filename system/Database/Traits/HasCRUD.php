<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasCRUD
{

    protected function saveMethod()
    {
        $fillable = $this->fill();

        if (!isset($this->{$this->primaryKey})) {
            $this->setSql("INSERT INTO " . $this->getTableName() . " SET " . $fillable . ",{$this->getAttributeName($this->createdAt)}=Now()");
        } else {
            $this->setSql("UPDATE " . $this->getTableName() . " SET " . $fillable . ",{$this->getAttributeName($this->updatedAt)}=Now()");
            $this->setWhere('AND', $this->getAttributeName($this->primaryKey) . "=?");
            $this->addValues($this->primaryKey, $this->{$this->primaryKey});
        }
        $this->executeQuery();
        $this->restQuery();
        if (!isset($this->{$this->primaryKey})) {
            $object = $this->findMethod(DBConnection::newInsertID());
            $classVars = get_class_vars(get_called_class());
            $objectClass = get_object_vars($object);
            $differentVars = array_diff(array_keys($objectClass), array_keys($classVars));
            foreach ($differentVars as $attribute) {
                $this->inCastsAttributes($attribute) == true ? $this->registerAttribute($this, $attribute, $this->castEnCodeValue($attribute, $object->$attribute)) : $this->registerAttribute($this, $attribute, $object->$attribute);
            }
        }

        $this->restQuery();
        $this->setAllowedMethods(['find', 'update', 'delete']);
        return $this;
    }

    protected function fill()
    {
        $fillArray = array();
        foreach ($this->filable as $attribute) {
            if (isset($this->$attribute)) {
                array_push($fillArray, $this->getAttributeName($attribute) . " =?");
                $this->inCastsAttributes($attribute) == true ? $this->addValues($attribute, $this->castEnCodeValue($attribute, $this->$attribute)) : $this->addValues($attribute, $this->$attribute);
            }
        }
        $fillString = implode(',', $fillArray);
        return $fillString;
    }

    protected function deleteMethod($id = null)
    {
        $object = $this;
        if (isset($id)) {
            $object = $this->findMethod($id);
            $this->restQuery();
        }
        $object->setSql('DELETE FROM ' . $this->getTableName());
        $object->setWhere('AND', $object->getAttributeName($object->primaryKey) . "=?");
        $this->addValues($object->primaryKey, $object->{$object->primaryKey});
        return $object->executeQuery();

    }

    protected function allMethod()
    {
        $this->setSql('SELECT ' . $this->getTableName() . '.*' . ' FROM ' . $this->getTableName());
        $statement = $this->executeQuery();
        $date = $statement->fetchAll();
        if ($date) {
            $this->arrayToObject($date);
            return $this->collection;
        }
        return [];
    }

    protected function findMethod($id)
    {
        $this->setSql('SELECT ' . $this->getTableName() . '.*' . ' FROM ' . $this->getTableName());
        $this->setWhere('AND', $this->getAttributeName($this->primaryKey) . "=?");
        $this->addValues($this->primaryKey, $id);
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        $this->restQuery();
        $this->setAllowedMethods(['delete', 'update', 'save']);
        if (!empty($record))
            return $this->arrayToAttributes($record);
        return null;
    }

    protected function whereMethod($attribute, $firstValue, $secondValue = null)
    {
        if ($secondValue === null) {
            $condition = $this->getAttributeName($attribute) . " =?";
            $this->addValues($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . " $firstValue " . '?';
            $this->addValues($attribute, $secondValue);
        }
        $operation = 'AND';
        $this->setWhere($operation, $condition);
        $this->setAllowedMethods(['delete', 'update', 'save', 'whereIn', 'orderBy', 'limit', 'get', 'whereNull', 'whereNotNull', 'whereOr', 'whereIn', 'paginate', 'first']);
        return $this;

    }

    protected function whereOrMethod($attribute, $firstValue, $secondValue = null)
    {
        if ($secondValue === null) {
            $condition = $this->getAttributeName($attribute) . " =?";
            $this->addValues($attribute, $firstValue);
        } else {
            $condition = $this->getAttributeName($attribute) . " $firstValue " . '?';
            $this->addValues($attribute, $secondValue);
        }
        $operation = 'OR';
        $this->setWhere($operation, $condition);
        $this->setAllowedMethods(['delete', 'update', 'save', 'whereIn', 'orderBy', 'limit', 'get', 'whereNull', 'whereNotNull', 'whereOr', 'whereIn', 'paginate', 'first']);
        return $this;

    }

    protected function whereNotNullMethod($attribute)
    {
        $this->setWhere('AND', $this->getAttributeName($attribute) . ' IS NOT NULL ');
        $this->setAllowedMethods(['delete', 'update', 'save', 'whereIn', 'orderBy', 'limit', 'get', 'whereNull', 'whereNotNull', 'whereOr', 'whereIn', 'paginate', 'first']);
        return $this;
    }

    protected function whereNullMethod($attribute)
    {
        $this->setWhere('AND', $this->getAttributeName($attribute) . ' IS NULL ');
        $this->setAllowedMethods(['delete', 'update', 'save', 'whereIn', 'orderBy', 'limit', 'get', 'whereNull', 'whereNotNull', 'whereOr', 'whereIn', 'paginate', 'first']);
        return $this;
    }

    protected function whereInMethod($attribute, $filed)
    {
        $items = array();
        if (is_array($filed)) {
            foreach ($filed as $value) {
                $this->addValues($attribute, $value);
                array_push($items, '?');
            }
            $condition = implode(',', $items);
        } else {
            $condition = '?';
            $this->addValues($attribute, $filed);
        }

        $this->setWhere('ADN', $this->getAttributeName($attribute) . " IN (" . $condition . " )");
        $this->setAllowedMethods(['delete', 'update', 'save', 'whereIn', 'orderBy', 'limit', 'get', 'whereNull', 'whereNotNull', 'whereOr', 'paginate', 'first']);
        return $this;
    }

    protected function orderByMethod($attribute, $expression)
    {
        $this->setOrderBy($this->getAttributeName($attribute), $expression);
        $this->setAllowedMethods(['delete', 'update', 'save', 'orderBy', 'limit', 'get', 'paginate', 'first']);
        return $this;
    }

    protected function limitMethod($limit, $offset)
    {
        $this->setLimit($limit, $offset);
        $this->setAllowedMethods(['delete', 'update', 'save', 'orderBy', 'get', 'paginate', 'first']);
        return $this;
    }

    protected function getMethod($fields = array())
    {
        if ($this->getSql() == '') {
            if (empty($fields)) {
                $fields = $this->getTableName() . ".*";
            } else {
                foreach ($fields as $key => $field) {
                    $fields[$key] = $this->getAttributeName($field);
                }
                $fields = implode(',', $fields);
            }
            $this->setSql('SELECT ' . $fields . " FROM " . $this->getTableName());
        }
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        $this->restQuery();
        if ($data) {
            $this->arrayToObject($data);
            return $this->collection;
        }
        return [];
    }

    protected function createMethod($fields)
    {
        $fields = $this->arrayToCastEnCodeValue($fields);
        $this->arrayToAttributes($fields, $this);
        return $this->saveMethod();
    }

    protected function updateMethod($fields)
    {
        $fields = $this->arrayToCastEnCodeValue($fields);
        $this->arrayToAttributes($fields, $this);
        return $this->saveMethod();
    }

    protected function firstMethod()
    {
        if ($this->getSql() == '') {
            $this->setSql('SELECT ' . $this->getTableName() . '.*' . ' FROM ' . $this->getTableName());
        }
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        if ($record) {
            return $this->arrayToAttributes($record);
        }
        return null;
    }
}