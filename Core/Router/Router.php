<?php 

namespace Core\Router;

use App\Traits\ArrayShift;
use App\Traits\SortArray;
use Core\Router\Route;


class Router{

    use SortArray,ArrayShift;

    public array $method = ['GET','POST'];

    public array $routes = [];

    public array $name;

    public array $matches;

    public string|array $routeParameters; 

    public bool $match = false;

    public array $key;
    
    /**
     * get
     *
     * @param  mixed $uri
     * @param  mixed $controller_name
     * @param  mixed $controller_method
     * @return Router
     */
    public function get(string $uri,$controller_name,string $controller_method) : Router
    {
        $route = new Route($uri,$controller_name,$controller_method);
        $this->routes[] = $route;
        if(str_contains($uri,':')){
            $parameter = preg_split('#/#',str_replace(':','',$uri));   
            $this->routeParameters = $this->arrayShiftWithLevel($parameter,2);
        }
    
        return $this;
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
    
    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        foreach($this->routes as $route){
            $action = $route->controller_method;
            $path = preg_replace('#:([\w]+),?#', '([^/]+)', $route->uri);
            $regex = "{^$path$}";
            if($_SERVER['REQUEST_URI'] == $route->uri || preg_match_all($regex,$_SERVER['REQUEST_URI'],$matches,PREG_SET_ORDER)){ 
                $controller_name = NAMESPACE_CONTROLLER . $route->controller_name;
                $controller = new $controller_name();
                
                if(!empty($matches)){
                    $sortMatches = $this->sortArray($matches);
                    array_shift($sortMatches);
                    $this->matches = $sortMatches;
                    $arrayOfParameter = array_combine($this->routeParameters,$this->matches);
                    return call_user_func_array([$controller,$action],$arrayOfParameter);
                }
                else{
                    return $controller->$action();
                }    

                $this->match = true;
                break;
            }
        }    

        if(!$this->match){
            http_response_code(404);
            echo "La route demandé n'existent pas";
            return;
        }
    }





}