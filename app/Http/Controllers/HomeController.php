<?php

namespace App\Http\Controllers;

use App\Http\Request\PostRequest;
use App\Http\Request\UserRequest;
use App\Model\Post;
use App\Model\Role;
use App\Model\User;
use System\Auth\Auth;

class HomeController
{
    public function index()
    {
        $test=new Auth();
        dd($test->hossein());
    }
}