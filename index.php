<?php

//REMOVE THIS
ini_set('error_reporting', E_ALL);


//Core
require_once "./vendor/autoload.php";
include_once "./core/Router.php";

//App Components
include_once "./presentation/ExchangeController.php";
include_once "./useCase/ExchangeUseCase.php";
include_once "./useCase/RecomendationUseCase.php";

//Environment variables
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');


//Routing
$router = new Router;

$router->registerDefaultHandler(function() {
    echo "This page doesn't exist. Please, try another one";
});

$router->get("/exchange", function() {
    $controller = new ExchangeController(new ExchangeUseCase);
    return $controller->exchange();
});

$router->get('/recomendation', function() {
    $controller = new ExchangeController(new RecomendationUseCase);
    return $controller->recomendation();
});
