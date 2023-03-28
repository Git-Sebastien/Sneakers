<?php

namespace App\Http\Middleware;

class Admin{

    public function handle($next,$request)
    {
        $admin = true;
        if($admin == false){
            return header('Location:/error');
            exit();
        }     
        return $next($request);
    }
}