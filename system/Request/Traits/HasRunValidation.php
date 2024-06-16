<?php

namespace System\Request\Traits;

trait HasRunValidation
{
    private function errorRedirect()
    {
        if ($this->errorExist === false) {
            return $this->request;
        }
        back();
    }

    private function checkFirstError($attribute)
    {
        if (!errorExist($attribute) and !in_array($attribute, $this->errorVariableName)) {
            return true;
        }
        return false;
    }

    private function checkFiledExist($attribute)
    {
        if (isset($this->$attribute) and !empty($this->$attribute)) {
            return true;
        }
        return false;
    }

    private function checkFileExist($attribute)
    {
        if (isset($this->files[$attribute]['name']) and !empty($this->files[$attribute]['name'])) {
            return true;
        }
        return false;
    }

    private function setError($attribute,$message)
    {
            array_push($this->errorVariableName,$attribute);
            $this->errorExist=true;
            error($attribute,$message);
    }
}