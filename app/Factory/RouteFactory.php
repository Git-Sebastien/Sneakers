<?php 

namespace App\Factory;

use Core\Router\Route;

class RouteFactory{

    public static function create(string $uri,string $controller_name,string $controller_method)
    {
        return new Route($uri,$controller_name,$controller_method);
    }

}