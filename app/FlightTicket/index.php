<?php

/*
GRU,BRC,10
GRU,SCL,18
GRU,ORL,56
GRU,CDG,75
SCL,ORL,20
BRC,SCL,5
ORL,CDG,5
*/
// Determinar todas as rotas possíveis
// Determinar a mais barata entre as possíveis

function dd(...$params)
{
    var_dump(...$params); exit();
}

require_once 'Location.php';
require_once 'Destination.php';
require_once 'Route.php';
require_once 'CheapestRouteResolver.php';

$gru = new Location('gru');
$slc = new Location('slc');
$brc = new Location('brc');
$orl = new Location('orl');
$cdg = new Location('cdg');

$gru->setDestinations([
    new Destination($brc, 10),
    new Destination($slc, 18),
    new Destination($orl, 56),
    new Destination($cdg, 75)
]);

$slc->setDestinations([
    new Destination($orl, 20),
]);

$brc->setDestinations([
    new Destination($slc, 5),
]);

$orl->setDestinations([
    new Destination($cdg, 5),
]);

$routeResolver = new CheapestRouteResolver();
$routes = $routeResolver->getPossibleRoutes($gru, $slc);

/*$routes = array_map(function ($route) {

    $route = array_map(function ($location) {
        return $location->getName();
    }, $route);

    return $route;

}, $routes);*/

foreach ($routes as $route) {
    var_dump('$route->fullPath(), $route->getCost()');
    var_dump($route->fullPath() .' - '. $route->getCost());
}

