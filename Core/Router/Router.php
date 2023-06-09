<?php 

namespace Core\Router;

use App\Factory\RouteFactory;
use Core\Router\Route;
use App\Traits\SortArray;
use App\Traits\ArrayShift;
use ReflectionClass;

class Router extends Route{

    use SortArray,ArrayShift;

    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $method = ['GET','POST'];
    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $routes = [];
    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $name;
    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $matches;
    /**
     * Undocumented variable
     *
     * @var string|array
     */
    public string|array $routeParameters; 
    /**
     * Undocumented variable
     *
     * @var boolean
     */
    public bool $match = false;

    public array $key;

    public function __construct()
    {}

    /**
     * get
     *
     * @param  mixed $uri
     * @param  mixed $controller_name
     * @param  mixed $controller_method
     * @return Router
     */
    public function get(string $uri,string $controller_name,string $controller_method)
    {        
        $route = RouteFactory::create($uri,$controller_name,$controller_method);
        $this->routes[] = $route;
   
        return $route;
    }

    /**
     * name
     *
     * @param  mixed $name
     * @return Router
     */
    public function name(string $name) :Router
    {
        $this->name[] = $name;

        return $this;
    }

    public function getMiddleware($middleware,$controller,$action,$parameters)
    {
        $middleware_name = NAMESPACE_MIDDLEWARE . $middleware;
        $middleware_instance = new $middleware_name();
        $next = function() use ($controller, $action, $parameters) {
            return call_user_func_array([$controller, $action], $parameters);
        };
        $middleware_instance->handle($next,http_response_code(302));
    }

    public function splitParameter(array $matches,string $uri)
    {
        if(!empty($matches)){
            $parameter = preg_split('#/#',$uri);
            foreach($parameter as $routeParameter){
                if(str_contains($routeParameter,':')){
                    $routeParameters[] = str_replace(':','',$routeParameter);
                }
            }
            $sortMatches = $this->sortArray($matches);
            array_shift($sortMatches);
            $this->matches = $sortMatches;
            $parameters = array_combine($routeParameters,$this->matches);
        }
        return $parameters ?? [];
    }

    /**
     *Check the routes and return method if match happened
     * @return void
     */
    public function run()
    {
        $arrayOfParameter = [];
        foreach($this->routes as $route){
            $action = $route->controller_method;
            $path = preg_replace('#:([\w]+),?#', '([^/]+)', $route->uri); 
            $regex = "{^$path$}";

            if($_SERVER['REQUEST_URI'] == $route->uri || preg_match_all($regex,$_SERVER['REQUEST_URI'],$matches,PREG_SET_ORDER)){ 
                $controller_name = NAMESPACE_CONTROLLER . $route->controller_name;
                $controller = new $controller_name();
                $arrayOfParameter = $this->splitParameter($matches,$route->uri);

                if(!empty($route->middleware)){ 
                    $this->getMiddleware($route->middleware,$controller,$action,$arrayOfParameter);
                }
                else{
                    return $controller->$action();
                }
            }
            $this->match = true;
        }   
            
        if(!$this->match){
            http_response_code(404);
            echo "La route demandé n'existent pas";
            return;
        }
    }
}




