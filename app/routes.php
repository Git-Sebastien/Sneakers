<?php 

use Core\Router\Router;

$router = new Router();
$router->get('/user/:id','HomeController','index')->middleware('Admin');
$router->get('/','HomeController','create')->middleware('Admin');
$router->get('/users/:email/:id','PostsController','index')->middleware('User');
$router->get('/error','ErrorController','index');
$router->get('/posts/:mail','HomeController','show')->middleware('Admin');
$router->run();