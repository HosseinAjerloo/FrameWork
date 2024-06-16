<?php

namespace System\Session;

class Session
{
    public function set($name,$value)
    {
        $_SESSION[$name]=$value;
    }
    public function get($name)
    {
        if (isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
        return null;
    }
    public function remove($name)
    {
        if (isset($_SESSION[$name]))
        {
             unset($_SESSION[$name]);
             return true;
        }
        return false;
    }
    public static function __callStatic($name, $arguments)
    {
        return self::call($name,$arguments);
    }
    private static function call($name,$argument)
    {
        return call_user_func_array(array(new self(),$name),$argument);
    }
}