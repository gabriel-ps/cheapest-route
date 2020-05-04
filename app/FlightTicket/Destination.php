<?php

namespace App\FlightTicket;

/**
 *
 */
class Destination
{
    private $location;
    private $cost;

    function __construct(Location $location, float $cost)
    {
        $this->location = $location;
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getLocationCode()
    {
        return $this->location->getCode();
    }

    /**
     * @param mixed $location
     *
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     *
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }
}
