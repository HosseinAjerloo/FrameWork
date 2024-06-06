<?php

namespace System\Router;

use App\Http\Request\UserRequest;
use System\Error\Abort;
use System\Request\Request;

class Routing
{
    private $current_route;
    private $method_filed;
    private $routes;
    private $value = [];
    private $methodParameter = [];


    public function __construct()
    {
        $this->current_route = explode('/', CURRENT_ROUTE);
        $this->method_filed = $this->methodFiled();
        global $routes;
        $this->routes = $routes;
    }

    public function run()
    {
        $match = $this->match();
        if (empty($match))
            $this->errorResponse404();
        $this->calledClass($match);
    }

    private function calledClass($object)
    {
        try {
            if (!class_exists($object['class']))
                throw new \Exception("It is not {$object['class']} `s class");
            if (!method_exists($object['class'], $object['method']))
                throw new \Exception("It is not {$object['method']} `s method");
            $this->runCalled($object);
        } catch (\Exception $e) {
            Abort::abort(500);
            exit($e->getMessage());
        }
    }

    private function runCalled($objectClass)
    {

        try {
            $class = new $objectClass['class']();
            $reflectionClass = new \ReflectionClass($class);;
            $reflectionParameterNum = $reflectionClass->getMethod($objectClass['method'])->getParameters();
            $sophie = array_filter($reflectionParameterNum, function ($parameter) {
                if (!$parameter->getClass()) {
                    return $parameter;
                }
            });
            if (sizeof($sophie) != sizeof($this->value))
                throw new \Exception('The number of values ​​passed to the desired method is incorrect');

            foreach ($reflectionParameterNum as $parameter) {

                if ($parameter->getClass() and $parameter->getClass()->getParentClass()->name === 'System\Request\Request') {

                    $request = new($parameter->getClass()->name)();
                    $this->methodParameter[$parameter->getPosition()] = $request;


                }
            }

            $this->setParameterForMethodCalled();


            $this->callMethod($class, $objectClass['method']);


        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    private function callMethod($class, $method)
    {
        return call_user_func_array(array($class, $method), $this->methodParameter);
    }

    private function setParameterForMethodCalled()
    {
        foreach ($this->value as $key => $value) {
            $status = true;
            while ($status) {
                if (!empty($this->methodParameter) and in_array($key, array_keys($this->methodParameter))) {
                    $key+=1;
                } else {
                    $status=false;
                }
            }

            $this->methodParameter[$key] = $value;
            ksort($this->methodParameter);
        }
    }

    private function findPositionParameter()
    {

    }


    public function match(): array
    {
        $reserveRoutes = $this->routes[$this->method_filed];
        foreach ($reserveRoutes as $routes) {
            if ($this->compare($routes['url'])) {
                return ['class' => $routes['class'], 'method' => $routes['method']];
            } else {
                $this->value = [];
            }
        }
        return [];
    }

    private function compare($reserveRouteUrl): bool
    {
        if (trim($reserveRouteUrl, '/') == '') {
            return trim($this->current_route[0], '/') === '' ? true : false;
        }
        $reserveRouteUrlArray = explode('/', $reserveRouteUrl);
        if (sizeof($this->current_route) != sizeof($reserveRouteUrlArray)) {
            return false;
        }
        foreach ($this->current_route as $key => $currentRoute) {
            $reserveRouteUrlArrayElement = $reserveRouteUrlArray[$key];
            if (substr($reserveRouteUrlArrayElement, 0, 1) == "{" and substr($reserveRouteUrlArrayElement, -1) == "}") {
                array_push($this->value, $currentRoute);
            } elseif ($currentRoute != $reserveRouteUrlArrayElement) {
                return false;
            }
        }
        return true;

    }


    private function errorResponse404()
    {
        http_response_code(404);
        Abort::abort(404);
        exit;
    }

    private function methodFiled()
    {
        $method = 'GET';
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            $method = 'POST';
            if (isset($_POST['_method'])) {
                if ($_POST['_method'] == 'put') {
                    $method = 'PUT';
                } elseif ($_POST['_method'] == 'delete') {
                    $method = 'DELETE';
                }
            }

        }
        return $method;
    }

}