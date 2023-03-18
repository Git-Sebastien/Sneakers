<?php 
namespace Core\AppLoader;

define('ROOT',str_replace(['index.php','\public'],'',$_SERVER['SCRIPT_FILENAME']));    
define('NAMESPACE_CONTROLLER',"App\\Http\\Controllers\\");

abstract class AppLoader{

   
    public static function load()
    {
        require ROOT .'app'.DIRECTORY_SEPARATOR.'routes.php';
    }
}