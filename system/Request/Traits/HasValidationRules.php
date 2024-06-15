<?php

namespace System\Request\Traits;

use App\Model\Post;
use System\Database\DBConnection\DBConnection;

trait HasValidationRules
{
    protected function normalValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                $this->required($attribute, $rule);
            } elseif (str_contains($rule, 'max:')) {
                $rule = str_replace('max:', '', $rule);
                $this->maxStr($attribute, $rule);
            } elseif (str_contains($rule, 'min:')) {
                $rule = str_replace('min:', '', $rule);
                $this->minStr($attribute, $rule);
            } elseif (str_contains($rule, 'exists:')) {
                $rule = str_replace('exists:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->existsIn($attribute, $rule[0], $key);
            } elseif ($rule == 'email') {
                $this->email($attribute, $rule);
            } elseif ($rule == 'date') {
                $this->date($attribute, $rule);
            }


        }
    }

    protected function numberValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                $this->required($attribute, $rule);
            } elseif (str_contains($rule, 'max:')) {
                $rule = str_replace('max:', '', $rule);
                $this->maxNumber($attribute, $rule);
            } elseif (str_contains($rule, 'min:')) {
                $rule = str_replace('min:', '', $rule);
                $this->minNumber($attribute, $rule);
            } elseif (str_contains($rule, 'exists:')) {
                $rule = str_replace('exists:', '', $rule);
                $rule = explode(',', $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->existsIn($attribute, $rule[0], $key);
            } elseif ($rule == 'number') {
                $this->number($attribute, $rule);
            }


        }
    }

    protected function maxStr($attribute, $rule)
    {
        if ($this->checkFiledExist($attribute)) {
            if (strlen($this->$attribute) >= $rule && $this->checkFirstError($attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function minStr($attribute, $rule)
    {
        if ($this->checkFiledExist($attribute)) {
            if (strlen($this->$attribute) <= $rule && $this->checkFirstError($attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function maxNumber($attribute, $rule)
    {
        if ($this->checkFiledExist($attribute)) {
            if ($this->$attribute >= $rule && $this->checkFirstError($attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function minNumber($attribute, $rule)
    {
        if ($this->checkFiledExist($attribute)) {
            if ($this->$attribute <= $rule && $this->checkFirstError($attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function required($attribute)
    {
        if ((!isset($this->$attribute) or $this->$attribute === '') and $this->checkFirstError($attribute)) {
            $this->setError($attribute, 'متن خطا');
        }
    }

    protected function number($attribute)
    {
        if ($this->checkFiledExist($attribute)) {
            if (!is_numeric($this->$attribute) and $this->checkFirstError($attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function date($attribute)
    {
        if ($this->checkFiledExist($attribute)) {
            if ($this->checkFirstError($attribute) and !preg_match('/(([1-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))/im', $this->$attribute)) {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }

    protected function email($attribute)
    {
        if ($this->checkFiledExist($attribute)) {
            if ($this->checkFirstError($attribute) and !filter_var($this->$attribute, FILTER_VALIDATE_EMAIL)) {
                $this->setError($attribute, 'متن خطا');

            }
        }
    }

    protected function existsIn($attribute, $tableName, $key = 'id')
    {
        if ($this->checkFiledExist($attribute)) {
            if ($this->checkFirstError($attribute)) {
                    $value=$this->$attribute;
                    $statement=DBConnection::getInstanceDBConnection()->prepare('SELECT COUNT(*) FROM '.$tableName.' WHERE '.$key." =?");
                    $statement->execute([$value]);
                    $result=$statement->fetchColumn();
                    if ($result==0 or $result===false)
                    {
                        $this->setError($attribute, 'متن خطا');
                    }
            }
        }
    }

}