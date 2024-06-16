<?php

namespace System\View;

use System\View\Traits\HasExtendsContent;
use System\View\Traits\HasViewLoader;

class ViewBuilder
{
    use HasViewLoader,HasExtendsContent;
    public $content;
    public function run($dir)
    {
        $this->content=$this->viewLoader($dir);
        $this->checkExtendsContent($this->content);
    }


}