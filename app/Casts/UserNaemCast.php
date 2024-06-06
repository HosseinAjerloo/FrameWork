<?php

namespace App\Casts;

use System\Database\Casts\Casting;

class UserNaemCast implements Casting
{

    public function toCastValue($attribute, $value)
    {
       return json_encode($value);
    }

    public function getCastValue($attribute, $value)
    {
        return json_decode($value,true);
    }
}