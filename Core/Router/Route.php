<?php 

namespace Core\Router;

class Route{

    public function __construct(
        public string $uri,
        public string $controller_name,
        public string $controller_method,
        public ?string $middleware = null,
        public ?array $middleware_config = null
    )
    {}  

    public function middleware(string|array $middleware)
    {
        $this->middleware_config = require ROOT . 'app/config/middleware.php';
        foreach(array_keys($this->middleware_config) as $middleware_array){
            if($middleware == $middleware_array){
                $this->middleware = $middleware;
            }
        }
        return $this;
    }
}