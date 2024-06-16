<?php

namespace System\Auth;

use App\Model\Post;
use App\Model\User;
use System\Session\Session;

class Auth
{
    private $redirectTo = '/login';

    private function userMethod()
    {
        if (!Session::get('user')) {
            return redirect($this->redirectTo);
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        }
        return $user;
    }
    private function checkMethod()
    {
        if (!Session::get('user')) {
            return redirect($this->redirectTo);
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return redirect($this->redirectTo);
        }
        return true;
    }
    private function checkLogin()
    {
        if (!Session::get('user')) {
            return false;
        }
        $user = User::find(Session::get('user'));
        if (empty($user)) {
            Session::remove('user');
            return  false;
        }
        return true;
    }


    public function __call($name, $arguments)
    {
        return $this->methodCaller($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = new self();
        return $instance->methodCaller($name, $arguments);
    }
    private function methodCaller($name, $argument)
    {
        $suffix = 'method';
        $name = $name . $suffix;
        return call_user_func_array(array($this, $name), $argument);
    }
}