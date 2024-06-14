<?php

use System\Router\Routing;
$string='max:250';
$node= strpos($string,'max:')."<br>";
echo $node."<hr>";
echo substr($string,(int)$node);
die('end');
require_once realpath(dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
require_once realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap'.DIRECTORY_SEPARATOR.'app.php');
(new Routing())->run();





