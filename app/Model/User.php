<?php

namespace App\Model;

use App\Casts\UserNaemCast;
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class User extends Model
{
    use HasSoftDelete;



    protected $filable = ['name', 'family', 'phone'];
    protected $deletedAt='deleted_at';


    public function profile()
    {
       return $this->hasOne(Post::class,'user_id');
    }

    public function profiles()
    {
        return $this->hasMany(Post::class,'user_id');
    }
    public function roles()
    {
        return $this->belongToMany(Role::class,'role_user','user_id','role_id');
    }
}