<?php 

use Core\Router\Router;

$router = new Router();
$router->get('/user/:id','HomeController','index')->middleware('Admin');
$router->get('/','HomeController','create')->middleware('Admin');
$router->get('/users/:email/:id','PostsController','index')->middleware('User');
$router->get('/error','ErrorController','index');
$router->get('/posts/:mail','HomeController','show')->middleware('Admin');
$router->run();

//TODO Continué la base de donnée avec plusieurs méthodes
// Réussir a aller cherché les données dans la base de données d'une maniére plus propre et implémenté les requêtes préparé avec une méthode ^pur ajouter des quotes.
//Crée des utilisateurs.
//Systéme de log pour la base de données et pourquoi pa test sur les connexion sur l'appli

