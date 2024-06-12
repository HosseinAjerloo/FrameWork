<?php

namespace App\Http\Controllers;

use App\Http\Request\PostRequest;
use App\Http\Request\UserRequest;
use App\Model\Post;
use App\Model\Role;
use App\Model\User;

class HomeController
{
    public function index()
    {
        dd(User::find(2)->roles());
    }
}