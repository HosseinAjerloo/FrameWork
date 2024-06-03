<?php

namespace System\Database\Traits;
trait HasAttributes
{
    private function registerAttribute($object, string $attribute, $value)
    {
        $this->inCastsAttributes($attribute) == true ? $object->$attribute = $this->castDeCodeValue($attribute, $value) : $object->$attribute = $value;
    }

    protected function arrayToAttributes(array $array, $object = null)

    {
        if (!$object) {
            $object = (new (get_called_class()));
        }
        foreach ($array as $attribute => $value) {
            if ($this->inHiddenAttributes($attribute))
                continue;
            $this->registerAttribute($object, $attribute, $value);
        }
        return $object;
    }

    protected function arrayToObject()
    {

    }

    protected function inHiddenAttributes($attribute): bool
    {
        return false;
    }

    private function inCastsAttributes($attribute): bool
    {
        return false;
    }

    private function castDeCodeValue()
    {

    }

    protected function castEnCodeValue()
    {

    }

    private function arrayToCastEnCodeValue()
    {

    }
}