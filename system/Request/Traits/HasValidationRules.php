<?php

namespace System\Request\Traits;

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
                $this->existsIn($attribute, $rule[0],$key);
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
                $this->existsIn($attribute, $rule[0],$key);
            }  elseif ($rule == 'number') {
                $this->number($attribute, $rule);
            }


        }
    }

    protected function maxStr($attribute,$rule)
    {
        if ($this->chedckFiledExist($attribute))
        {
                if (strlen($this->$attribute)>=$rule && $this->checkFirstError($attribute))
                {
                    $this->setError($attribute,'متن خطا');
                }
        }
    }
    protected function minStr($attribute,$rule)
    {
        if ($this->chedckFiledExist($attribute))
        {
            if (strlen($this->$attribute)<=$rule && $this->checkFirstError($attribute))
            {
                $this->setError($attribute,'متن خطا');
            }
        }
    }
    protected function maxNumber($attribute,$rule)
    {
        if ($this->chedckFiledExist($attribute))
        {
            if ($this->$attribute>=$rule && $this->checkFirstError($attribute))
            {
                $this->setError($attribute,'متن خطا');
            }
        }
    }
    protected function minNumber($attribute,$rule)
    {
        if ($this->chedckFiledExist($attribute))
        {
            if ($this->$attribute<=$rule && $this->checkFirstError($attribute))
            {
                $this->setError($attribute,'متن خطا');
            }
        }
    }

}