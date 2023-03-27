<?php

namespace App\Http\Middleware;

class Admin{

    public function handle($next,$request)
    {
        $admin = false;
        if($admin == false){
            return header('Location:/error');
            exit();
        }     
        return $next($request);
    }
}