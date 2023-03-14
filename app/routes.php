<?php 

use Core\Router\Router;


$router = new Router();
$router->get('/','HomeController','index');
$router->run();

