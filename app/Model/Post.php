<?php

namespace App\Model;

use App\Casts\UserNaemCast;
use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Post extends Model
{
    use HasSoftDelete;

    protected $filable = ['description'];

        public function user()
        {
            return $this->belongTo(User::class,'user_id');
        }
}