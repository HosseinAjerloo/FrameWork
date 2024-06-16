<?php

namespace System\View\Traits;

trait HasExtendsContent
{
    private $extendContent;

    private function findExtends()
    {
        $filePathArray = array();
        preg_match("/(@extends)/", $this->content, $filePathArray);
        dd($filePathArray);
    }

    private function checkExtendsContent($content)
    {
        $this->findExtends();
    }
}