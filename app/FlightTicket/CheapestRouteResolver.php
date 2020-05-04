<?php

namespace App\FlightTicket;

/**
 *
 */
class CheapestRouteResolver
{
    public function resolve(Location $origin, Location $destination)
    {
        /*$destinations = $origin->getDestinations();

        foreach ($destinations as $destination) {
            # code...
        }

        while (!in_array($destination, $destinations)) {
            $this->resolve();
        }*/
        $routes = $this->getPossibleRoutes($origin, $destination);
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

    private function newRoute($routePrefix, $destination)
    {
        $routePrefix[] = $destination;
        return $route;
    }
}
