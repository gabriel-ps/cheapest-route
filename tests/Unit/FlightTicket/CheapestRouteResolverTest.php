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

        $this->assertCount(2, $routes);

        $this->assertEquals($routes[0]->fullPath(), 'gru,brc,slc');
        $this->assertEquals($routes[0]->getCost(), 15);

        $this->assertEquals($routes[1]->fullPath(), 'gru,slc');
        $this->assertEquals($routes[1]->getCost(), 18);



        $routes = $routeResolver->getPossibleRoutes($gru, $orl);

        $this->assertCount(3, $routes);

        $this->assertEquals($routes[0]->fullPath(), 'gru,brc,slc,orl');
        $this->assertEquals($routes[0]->getCost(), 35);

        $this->assertEquals($routes[1]->fullPath(), 'gru,slc,orl');
        $this->assertEquals($routes[1]->getCost(), 38);

        $this->assertEquals($routes[2]->fullPath(), 'gru,orl');
        $this->assertEquals($routes[2]->getCost(), 56);
    }
}