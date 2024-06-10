<?php

namespace App\Http\Controllers;

use App\Http\Request\PostRequest;
use App\Http\Request\UserRequest;
use App\Model\User;

class HomeController
{
    public function index()
    {
            $user=User::get();
            dd($user,$this);
    }
}