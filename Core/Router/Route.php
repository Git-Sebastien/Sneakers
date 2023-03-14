<?php 

namespace Core\Router;

class Route{

    public function __construct(
        public string $uri,
        public string $controller_name,
        public string $controller_method
    )
    {}
}