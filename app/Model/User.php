<?php
namespace App\Model;
use App\Casts\UserNaemCast;
use System\Database\ORM\Model;

class User extends Model
{

    protected $filable=['name','family','phone'];
    protected $casts=[
        'name'=>UserNaemCast::class
    ];
}