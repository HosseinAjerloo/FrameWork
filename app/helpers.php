<?php
function dd($argument)
{
    echo "<pre>";
    print_r($argument);
    echo "<pre>";
    exit();
}