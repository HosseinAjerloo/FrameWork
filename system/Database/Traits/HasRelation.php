<?php

namespace System\Database\Traits;

use System\Database\ORM\Model;

trait HasRelation
{
    protected function hasOne($related, $foreignKey)
    {
        $related = new $related();
        return $this->hasOneRelation($related, $foreignKey);
    }

    private function hasOneRelation($modelRelated, $foreignKey)
    {
        $this->setSql('SELECT `b`.* FROM ' . $this->getTableName() . ' as `a` JOIN ' . $modelRelated->getTableName() . ' as `b` ON  a.' . $this->primaryKey . "= b." . $foreignKey);
        $this->setWhere('ADN', "`a`.{$this->primaryKey}=?");
        $this->addValues($this->primaryKey, $this->{$this->primaryKey});
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        if ($statement) {
            return $this->arrayToAttributes($record);
        }
        return null;
    }


    protected function hasMany($related, $foreignKey)
    {
        $related = new $related();
        return $this->hasManyRelation($related, $foreignKey);
    }

    private function hasManyRelation($modelRelated, $foreignKey)
    {
        $this->setSql('SELECT `b`.* FROM ' . $this->getTableName() . ' as `a` JOIN ' . $modelRelated->getTableName() . ' as `b` ON  a.' . $this->primaryKey . "= b." . $foreignKey);
        $this->setWhere('ADN', "`a`.{$this->primaryKey}=?");
        $this->addValues($this->primaryKey, $this->{$this->primaryKey});
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObject($data);
            return $this->collection;
        }
        return null;
    }

    protected function belongTo($related, $pivotKey)
    {
        $related = new $related();
        return $this->belongToRelation($related, $pivotKey);
    }

    private function belongToRelation($related, $pivotKey)
    {
        $this->setSql('SELECT `b`.*  FROM ' . $this->getTableName() . ' as `a` JOIN  ' . $related->getTableName() . ' as `b` ON  a.' . $pivotKey . "= b." . $related->primaryKey);
        $this->setWhere('ADN', " a.{$this->primaryKey}=?");
        $this->addValues($this->primaryKey, $this->{$this->primaryKey});
        $statement = $this->executeQuery();
        $record = $statement->fetch();
        if ($statement) {
            return $this->arrayToAttributes($record);
        }
        return null;
    }


    protected function belongToMany($related, $pivotTable, $pivotFirstKey, $pivotSecondKey)
    {
        $related = new $related();
        return $this->belongToManyRelation($related, $pivotTable, $pivotFirstKey, $pivotSecondKey);
    }

    private function belongToManyRelation($related, $pivotTable, $pivotFirstKey, $pivotSecondKey)
    {
        $this->setSql("SELECT `c`.* FROM ( SELECT `b`.* FROM {$this->getTableName()} as `a` join {$pivotTable} as `b` on `a`.{$this->primaryKey}=`b`.{$pivotFirstKey} where `a`.{$this->primaryKey}=?) as `r` join {$related->getTableName()} as `c` on `r`.$pivotSecondKey=`c`.{$related->primaryKey}  ; ");
        $this->addValues($this->primaryKey, $this->{$this->primaryKey});

        $statement = $this->executeQuery();
        $data = $statement->fetchAll();
        if ($data) {
            $this->arrayToObject($data);
            return $this->collection;
        }
        return null;
    }


}