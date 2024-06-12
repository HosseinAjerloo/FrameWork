<?php

namespace System\Database\Traits;
trait HasSoftDelete
{
    protected function deleteMethod($id = null)
    {
        $object = $this;
        if (isset($id)) {
            $object = $this->findMethod($id);
            $this->restQuery();
        }

        if ($object) {
            $object->setSql('UPDATE ' . $this->getTableName() . ' SET ' . $this->getAttributeName($object->deletedAt) . ' =Now()');
            $object->setWhere('ADN', $this->getAttributeName($object->primaryKey) . "=?");
            $object->addValues($object->primaryKey, $object->{$object->primaryKey});
            $statement = $object->executeQuery();
        }
    }

    protected function findMethod($id)
    {
        $this->restQuery();
        $this->setSql('SELECT ' . $this->getTableName() . '.*' . ' FROM ' . $this->getTableName());
        $this->setWhere('ADN', $this->getAttributeName($this->primaryKey) . "=?");
        $this->whereNullMethod($this->deletedAt);
        $this->addValues($this->primaryKey, $id);
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        if (!empty($record))
            return $this->arrayToAttributes($record);
        else
            return null;
    }

    protected function allMethod()
    {
        $this->restQuery();
        $this->setSql(' SELECT ' . $this->getTableName() . '.*' . ' FROM ' . $this->getTableName());
        $this->whereNullMethod($this->deletedAt);
        $statement = $this->executeQuery();
        $date = $statement->fetchAll();
        if ($date) {
            $this->arrayToObject($date);
            return $this->collection;
        }
        return [];

    }

    protected function getMethod($fields = [])
    {
        if ($this->getSql() == '') {
            if (empty($fields)) {
                $fields = $this->getTableName() . '.*';

            } else {
                foreach ($fields as $key => $filed) {
                    $fields[$key] = $this->getAttributeName($filed);
                }
                $fields = implode(',', $fields);
            }
        }
        $this->setSql('SELECT ' . $fields . ' FROM ' . $this->getTableName());
        $this->whereNullMethod($this->deletedAt);
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if (!empty($data)) {
            $this->arrayToObject($data);
            return $this->collection;
        }
        return [];

    }

    protected function firstMethod()
    {
        if ($this->getSql()=='')
        {
            $this->setSql('SELECT '.$this->getTableName().'.*'.' FROM '.$this->getTableName());
        }
        $this->whereNullMethod($this->deletedAt);
        $statement=$this->executeQuery();
        $record=$statement->fetch();
        if ($record)
        {
            return $this->arrayToAttributes($record);
        }
        return  null;
    }
}