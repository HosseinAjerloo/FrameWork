<?php
function dd($argument)
{
    $argument=func_get_args();
    echo "<pre>";
    print_r($argument);
    echo "<pre>";
    exit();
}
function view($path)
{
    $view =new \System\View\ViewBuilder();
    $view->run($path);
}