<?php 

use Core\Router\Router;


$router = new Router();
$router->get('/:id','HomeController','index');
$router->get('/posts/:id','PostsController','index');
$router->run();

