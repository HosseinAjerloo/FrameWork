<?php

namespace App\Http\Controllers;

use App\Http\Request\PostRequest;
use App\Http\Request\UserRequest;

class HomeController
{
    public function index( $phone,PostRequest $postRequest, $code,UserRequest $request,$id)
    {
        $request->hossein();
        echo "<hr>";
        $postRequest->hossein();
        echo "<hr>";
        echo $id;
        echo "<hr>";
        echo $phone;
        echo "<hr>";
        echo $code;

    }
}