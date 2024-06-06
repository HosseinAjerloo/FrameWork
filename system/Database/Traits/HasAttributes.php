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

    protected function arrayToObject($array)
    {
        $collection = array();
        foreach ($array as $value) {
            array_push($collection, $this->arrayToAttributes($value));
        }
        $this->collection = $collection;
    }

    protected function inHiddenAttributes($attribute): bool
    {
        return in_array($attribute, $this->hidden);
    }

    private function inCastsAttributes($attribute): bool
    {
        return in_array($attribute, array_keys($this->casts));
    }

    private function castDeCodeValue($attribute, $value)
    {
        $reflection = $this->getInstanceReflection($this->casts[$attribute]);
        $classObj = $reflection->newInstanceWithoutConstructor();
        return $classObj->getCastValue($attribute, $value);
    }

    protected function castEnCodeValue($attribute, $value)
    {
        $reflection = $this->getInstanceReflection($this->casts[$attribute]);
        $classObj = $reflection->newInstanceWithoutConstructor();
        return $classObj->toCastValue($attribute, $value);
    }

    private function arrayToCastEnCodeValue($values)
    {
        $newValues = array();
        foreach ($values as $attribute => $value) {
            $this->inCastsAttributes($attribute) == true ? $newValues[$attribute] = $this->castEnCodeValue($attribute, $value) : $newValues[$attribute] = $value;
        }
        return $newValues;
    }

}