<?php 

namespace App\Facades;

use Core\Router\Router as Route;

class Router{

    public static $_instance;

    public static function __callStatic($method, $arguments)
    {
        if(is_null(self::$_instance)){
            self::$_instance = new Route();
        }

        return call_user_func_array([self::$_instance, $method], $arguments);
    }
}
