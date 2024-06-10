<?php

namespace App\Model;

use App\Casts\UserNaemCast;
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class User extends Model
{
    use HasSoftDelete;

    protected $filable = ['name', 'family', 'phone'];
    protected $casts = [
        'name' => UserNaemCast::class
    ];
}