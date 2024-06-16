<?php

namespace System\View\Traits;

trait HasViewLoader
{
    private $viewNameArray = [];

    private function viewLoader($dir)
    {

        $dir = trim($dir, ' .');
        $dir = str_replace('.', '/', $dir);
        $path = realpath(dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'View'.DIRECTORY_SEPARATOR . $dir . '.blade.php');
        if (file_exists($path)) {
            $this->registerView($dir);
            $content = htmlentities(file_get_contents($path));
            return $content;
        }
        throw new  \Exception("view {$dir} not found");
    }

    private function registerView($view)
    {
        array_push($this->viewNameArray, $view);
    }
}