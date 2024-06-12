<?php

namespace App\Http\Controllers;

use App\Http\Request\PostRequest;
use App\Http\Request\UserRequest;
use App\Model\Post;
use App\Model\User;

class HomeController
{
    public function index()
    {
        $post = Post::where('id', 1)->first();
        dd($post->user());
    }
}