<?php
namespace System\Database\Casts;
interface Casting
{
        public function toCastValue($attribute,$value);
        public function getCastValue($attribute,$value);
}