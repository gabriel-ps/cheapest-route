<?php

namespace App\FlightTicket;

/**
 *
 */
class CheapestRouteResolver
{
    public function resolve(Location $origin, Location $destination)
    {
        $routes = $this->getPossibleRoutes($origin, $destination);

        if (empty($routes)) {
            // No possible route
            return null;
        }

        if (count($routes) === 1) {
            // If there is only one route, it is the cheapest
            return $routes[0];
        }

        return $this->getCheapestRoute($routes);
    }

    private function getCheapestRoute(array $routes)
    {
        $minimunCost = $routes[0]->getCost();
        $minimunCostIndex = 0;

        for ($i = 1; $i < count($routes); $i++) {
            $route = $routes[$i];

            if ($route->getCost() < $minimunCost) {
                $minimunCost = $route->getCost();
                $minimunCostIndex = $i;
            }
        }

        return $routes[$minimunCostIndex];
        /*
        $minimunCost = INF;
        $minimunCostIndex = 0;

        foreach ($routes as $i => $route) {
            if ($route->getCost() < $minimunCost) {
                $minimunCost = $route->getCost();
                $minimunCostIndex = $i;
            }
        }

        return $routes[$minimunCostIndex];
        */
    }

    public function getPossibleRoutes($origin, Location $finalDestination, $accumulatedDestinations = []) : array
    {
        $routes = [];

        if ($origin instanceof Location) {
            $accumulatedDestinations[] = new Destination($origin, 0);
            $destinations = $origin->getDestinations();
        }
        else {
            $accumulatedDestinations[] = $origin;
            $destinations = $origin->getLocation()->getDestinations();
        }

        foreach ($destinations as $destination) {
            if ($destination->getLocationCode() == $finalDestination->getCode()) {
                // We found the final destination, and thereofore a new route to that destination
                $routes[] = new Route([
                    ...$accumulatedDestinations,
                    $destination
                ]);
            }
            else {
                // We need to go deeper
                array_push(
                    $routes,
                    ...$this->getPossibleRoutes($destination, $finalDestination, $accumulatedDestinations)
                );
            }
        }

        return $routes;
    }
}
