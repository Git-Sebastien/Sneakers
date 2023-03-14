<?php

namespace App\Config;


abstract class Config {

    public static string $root;


    public static function root()
    {
       return self::$root = str_replace(['index.php','\public'],'',$_SERVER['SCRIPT_FILENAME']);
    }    

    public static function getRoute()
    {
        require dirname(__DIR__) . DIRECTORY_SEPARATOR . '' . DIRECTORY_SEPARATOR . 'routes.php';
    }
}