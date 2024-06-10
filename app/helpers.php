<?php
function dd($argument)
{
    $argument=func_get_args();
    echo "<pre>";
    print_r($argument);
    echo "<pre>";
    exit();
}