<?php

namespace System\Error;


class Abort
{
    private $pages;

    private static function readPage($errorNum)
    {
        try {
        $file=__DIR__.DIRECTORY_SEPARATOR.'page'.DIRECTORY_SEPARATOR.$errorNum.'.html';

        if(file_exists($file))
        {
            require_once $file;
        }
        else{
            throw new \Exception('The requested file does not exist');
        }

        }catch (\Exception $e)
        {
            exit($e->getMessage());
        }
    }

    public static function abort($errorNum)
    {
        self::readPage($errorNum);
    }
}