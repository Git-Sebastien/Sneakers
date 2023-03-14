<?php 

namespace Core\Exceptions;

use Exception;

class RouterException extends Exception{

    public function RouteNotFound($route)
    {
        return "La route $route n'existe pas";
    }

}