<?php

use System\Router\Routing;
require_once realpath(dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
require_once realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap'.DIRECTORY_SEPARATOR.'app.php');
(new Routing())->run();





