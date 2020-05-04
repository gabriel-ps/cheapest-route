<?php

namespace App\Http\Controllers;

use App\FlightTicket\LocationsRepository;
use App\FlightTicket\CheapestRouteResolver;

class RoutesController extends Controller
{
    protected $locationsRepo;
    protected $routeResolver;
    protected $fileName = 'routes.csv';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LocationsRepository $locationsRepo, CheapestRouteResolver $routeResolver)
    {
        $this->locationsRepo = $locationsRepo;
        $this->routeResolver = $routeResolver;
    }

    public function findCheapestRotue($origin, $destination)
    {
        $locationsGraph = $this->locationsRepo->getAll($this->fileName);

        if (!isset($locationsGraph[$origin])) {
            abort(404);
        }
        if (!isset($locationsGraph[$destination])) {
            abort(404);
        }

        $route = $this->routeResolver->resolve($locationsGraph[$origin], $locationsGraph[$destination]);

        if (!$route) {
            abort(404);
        }

        return $route->toArray();
    }

    public function store()
    {
        $request = request();

        $data = $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'price' => 'required|numeric'
        ]);

        $this->locationsRepo->insert($this->fileName, $data);
    }
}
