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

    // public function checkParameter($controller,$method,$class,$arguments)
    // {
    //     $reflection  = new ReflectionClass($class);
    //     $parameters = $reflection->getMethod($method)->getParameters();
    //     foreach($arguments as $argument){
    //         foreach($parameters as $parameter){
    //             if(empty($parameters)){
    //                 die("Les paramétres de la méthode $method sont manquant");
    //             }
    //         }
    //     }
  
    //     return ;
    // }

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
            
                if(!empty($matches)){
                    $parameter = preg_split('#/#',$route->uri);
                    foreach($parameter as $routeParameter){
                        if(str_contains($routeParameter,':')){
                            $routeParameters[] = str_replace(':','',$routeParameter);
                        }
                    }
                    $sortMatches = $this->sortArray($matches);
                    array_shift($sortMatches);
                    $this->matches = $sortMatches;
                    $arrayOfParameter = array_combine($routeParameters,$this->matches);
                }

                if(!empty($route->middleware)){
                 
                    $middleware_name = NAMESPACE_MIDDLEWARE . $route->middleware;
                    $middleware = new $middleware_name();
                    $next = function() use ($controller, $action, $arrayOfParameter) {
                        return call_user_func_array([$controller, $action], $arrayOfParameter);
                    };
                    $middleware->handle($next,http_response_code(302));
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




