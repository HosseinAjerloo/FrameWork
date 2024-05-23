<?php
global $routes;

$routes =
    [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];
define('APP_TITLE', 'MVC_PROJECT');
define('BASE_URL', 'http://localhost:8000');
define('BASE_DIR', realpath(dirname(__DIR__)));
$temporary = str_replace(BASE_URL, '', explode('?', $_SERVER['REQUEST_URI'])[0]);
$temporary === '/' ? $temporary = '' : $temporary = substr($temporary, 1);
define('CURRENT_ROUTE', $temporary);

