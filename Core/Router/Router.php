<?php 

namespace Core\Router;

use Core\Exceptions\RouterException;
use Exception;
use Core\Router\Route;


class Router{

    public array $method = ['GET','POST'];

    public array $routes = [];

    public array $name;

    public bool $match = false;

    public function get(string $uri,$controller_name,string $controller_method) : Router
    {
        $route = new Route($uri,$controller_name,$controller_method);
        $this->routes[] = $route;

        return $this;
    }

    public function name(string $name) :Router
    {
        $this->name[] = $name;

        return $this;
    }

    public function run()
    {
        foreach($this->routes as $route){
            // dump($route->uri,$_SERVER['REQUEST_URI']);
            $action = $route->controller_method;
            if($_SERVER['REQUEST_URI'] == $route->uri){
                $namespace = "App\\Http\\Controllers\\";
                $controller_name = $namespace . $route->controller_name;
                $controller = new $controller_name();
                $controller->$action();
                return $this->match = true;
                break;
            }
        }    

        if(!$this->match){
            http_response_code(404);
            echo "La route demandé n'esitent pas";
            return;
        }
    }





}