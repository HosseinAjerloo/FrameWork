<?php


namespace System\Router\Api;


class Route
{
    private static $name;
    private static $type;

    public static function get($uri, $object)
    {
        global $routes;
        try {
            if (sizeof($object) == 2) {
                $controller = $object[0];
                $method = $object[1];
                $uri.='api/'.$uri;
                array_push($routes['GET'], ['url' => trim($uri, '/'), "class" => $controller, "method" => $method]);
                self::$type = 'GET';

            } else {
                throw new \Exception('The second step should include the class and method name in full', 500);
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        return new self();

    }

    public static function post($uri, $object)
    {
        global $routes;
        try {
            if (sizeof($object) == 2) {
                $controller = $object[0];
                $method = $object[1];
                $uri.='api/'.$uri;
                array_push($routes['POST'], ['url' => trim($uri, '/'), "class" => $controller, "method" => $method]);
                self::$type = 'POST';

            } else {
                throw new \Exception('The second step should include the class and method name in full', 500);
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        return new self();


    }

    public static function put($uri, $object)
    {
        global $routes;
        try {
            if (sizeof($object) == 2) {
                $controller = $object[0];
                $method = $object[1];
                $uri.='api/'.$uri;
                array_push($routes['PUT'], ['url' => trim($uri, '/'), "class" => $controller, "method" => $method]);
                self::$type = 'PUT';

            } else {
                throw new \Exception('The second step should include the class and method name in full', 500);
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        return new self();


    }

    public static function delete($uri, $object)
    {
        global $routes;
        try {
            if (sizeof($object) == 2) {
                $controller = $object[0];
                $method = $object[1];
                $uri.='api/'.$uri;
                array_push($routes['DELETE'], ['url' => trim($uri, '/'), "class" => $controller, "method" => $method]);
                self::$type = 'DELETE';

            } else {
                throw new \Exception('The second step should include the class and method name in full', 500);
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        return new self();


    }

    public static function name($name)
    {
        global $routes;
        $countRoutesType = sizeof($routes[self::$type]);
        $routes[self::$type][$countRoutesType - 1]['name'] = $name;

    }


}