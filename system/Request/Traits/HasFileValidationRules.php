<?php

namespace System\Request\Traits;

trait HasFileValidationRules
{
    protected function fileValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rules == 'required') {
                $this->requiredFile();
            } elseif (str_contains($rules, 'mimtypes:')) {
                $rule = str_replace('mimtypes:', '', $rule);
                $ruleArray = explode(',', $rule);
                $this->fileType($attribute, $ruleArray);
            } elseif (str_contains($rule, 'max:')) {
                    $rule=str_replace('max:','',$rule);
                    $this->maxFile($attribute,$rule);
            }
            elseif (str_contains($rule,'min:'))
            {
                $rule=str_replace('min:','',$rule);
                $this->minFile($attribute,$rule);
            }
        }
    }
    protected function requiredFile($attribute)
    {
        if ((!isset($this->files[$attribute]['name']) || empty($this->files[$attribute]['name'])) and $this->checkFirstError($attribute))
        {
            $this->setError($attribute, 'متن خطا');
        }
    }

    protected function fileType($attribute,$rule)
    {
        if ($this->checkFileExist($attribute) and $this->checkFirstError($attribute))
        {
            $fileType=$this->files[$attribute]['type'];
            $fileType=explode('/',$fileType)[1];
            if (!in_array($fileType,$rule))
            {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }
    protected function maxFile($attribute,$rule)
    {
        if ($this->checkFileExist($attribute) and $this->checkFirstError($attribute))
        {
            $size=$rule*1024;
            if ($this->files[$attribute]['size']>$size)
            {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }
    protected function minFile($attribute,$rule)
    {
        if ($this->checkFileExist($attribute) and $this->checkFirstError($attribute))
        {
            $size=$rule*1024;
            if ($this->files[$attribute]['size']<$size)
            {
                $this->setError($attribute, 'متن خطا');
            }
        }
    }
}