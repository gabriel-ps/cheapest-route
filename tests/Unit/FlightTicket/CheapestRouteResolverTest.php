<?php

use App\FlightTicket\Location;
use App\FlightTicket\Destination;
use App\FlightTicket\CheapestRouteResolver;

/*
GRU,BRC,10
GRU,SCL,18
GRU,ORL,56
GRU,CDG,75
SCL,ORL,20
BRC,SCL,5
ORL,CDG,5
*/
class CheapestRouteResolverTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_possible_routes()
    {
        $gru = new Location('GRU');
        $slc = new Location('SLC');
        $brc = new Location('BRC');
        $orl = new Location('ORL');
        $cdg = new Location('CDG');

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

        $this->assertCount(2, $routes);

        $this->assertEquals($routes[0]->fullPath(), 'GRU,BRC,SLC');
        $this->assertEquals($routes[0]->getCost(), 15);

        $this->assertEquals($routes[1]->fullPath(), 'GRU,SLC');
        $this->assertEquals($routes[1]->getCost(), 18);



        $routes = $routeResolver->getPossibleRoutes($gru, $orl);

        $this->assertCount(3, $routes);

        $this->assertEquals($routes[0]->fullPath(), 'GRU,BRC,SLC,ORL');
        $this->assertEquals($routes[0]->getCost(), 35);

        $this->assertEquals($routes[1]->fullPath(), 'GRU,SLC,ORL');
        $this->assertEquals($routes[1]->getCost(), 38);

        $this->assertEquals($routes[2]->fullPath(), 'GRU,ORL');
        $this->assertEquals($routes[2]->getCost(), 56);
    }

    /**
     * @test
     */
    public function it_resolves_cheapest_route()
    {
        $gru = new Location('GRU');
        $slc = new Location('SLC');
        $brc = new Location('BRC');
        $orl = new Location('ORL');
        $cdg = new Location('CDG');

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


        $route = $routeResolver->resolve($gru, $slc);

        $this->assertEquals($route->fullPath(), 'GRU,BRC,SLC');
        $this->assertEquals($route->getCost(), 15);


        $route = $routeResolver->resolve($gru, $orl);

        $this->assertEquals($route->fullPath(), 'GRU,BRC,SLC,ORL');
        $this->assertEquals($route->getCost(), 35);


        $route = $routeResolver->resolve($orl, $gru);

        // No possible route
        $this->assertEquals($route, null);
    }
}
