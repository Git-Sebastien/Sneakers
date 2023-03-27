<?php

namespace Core\Exceptions;

use Exception;
use ReflectionClass;

class RouteParameterException extends Exception{

    // public function parameterError(string $class,string $method,array|string $arguments,object $controller,)
    // {
    //     $reflection = new ReflectionClass($class);
    //     $method_parameter =  $reflection->getMethod($method)->getParameters();

    //     return !empty($method_parameter) ? call_user_func_array([$controller,$method],$arguments) :"";
    // }
}