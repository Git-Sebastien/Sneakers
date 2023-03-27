<?php

namespace App\Http\Middleware;

class User{

    public function handle($next,$request)
    {
        // dd($request);
        $admin = true;
        if($admin == false){
            return header('Location:/error');
            exit();
        }     
        // dd($next);  
        return $next($request);
    }
}