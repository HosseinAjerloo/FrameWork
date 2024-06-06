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

    protected function delete($id = null)
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
        $this->setWhere('AND', $this->getAttributeName($this->primaryKey)."=?");
        $this->addValues($this->primaryKey, $id);
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        $this->restQuery();
        $this->setAllowedMethods(['delete', 'update', 'save']);
        if ($record)
            return $this->arrayToAttributes($record);
        return null;
    }
}