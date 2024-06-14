<?php

namespace System\Request;

use App\Model\Post;
use System\Request\Traits\HasFileValidationRules;
use System\Request\Traits\HasRunValidation;
use System\Request\Traits\HasValidationRules;

class Request
{
    use HasFileValidationRules, HasRunValidation, HasValidationRules;

    protected $errorExist = false;
    protected $request;
    protected $files;
    protected $errorVariableName;

    public function __construct()
    {
        if (isset($_POST)) {
            $this->postAttributes();
        }
        if (!empty($_FILES)) {
            $this->files = $_FILES;
        }
        $rules = $this->rules();
        empty($rules) ?: $this->run($rules);
        $this->errorRedirect();
    }

    protected function postAttributes()
    {
        foreach ($_POST as $key => $postItem) {
            $this->request[$key] = $postItem;
            $this->$key = $postItem;
        }

    }

    protected function rules(): array
    {
        return [];
    }

    public function files($name)
    {
        return isset($this->files[$name]) ? $this->files[$name] : null;
    }

    public function all()
    {
        return $this->request;
    }

    protected function run($rules)
    {
        foreach ($rules as $attribute => $rule) {
            $arrayRule = explode('|', $rule);
            if (in_array('file', $arrayRule)) {
                unset($arrayRule[array_search('file',$arrayRule)]);
                $this->fileValidation($attribute,$attribute);

            } elseif (in_array('number', $arrayRule)) {
                $this->numberValidation($attribute,$attribute);
            } else {
                $this->normalValidation($attribute,$attribute);
            }
        }
    }
}