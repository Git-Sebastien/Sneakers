<?php 

namespace Core\AppLoader;

use App\Config\Config;


abstract class AppLoader{

    public static function load()
    {
        require config::root().'app'.DIRECTORY_SEPARATOR.'routes.php';
    }
}