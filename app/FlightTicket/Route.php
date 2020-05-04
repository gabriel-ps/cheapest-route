<?php

namespace App\FlightTicket;

/**
 *
 */
class Route
{
    protected $destinations = [];

    function __construct(array $destinations = [])
    {
        $this->destinations = $destinations;
    }

    /**
     * @return mixed
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * @param mixed $destinations
     *
     * @return self
     */
    public function setDestinations($destinations)
    {
        $this->destinations = $destinations;

        return $this;
    }

    /**
     * @return mixed
     */
    public function addDestination($destination)
    {
        $this->destinations[] = $destination;

        return $this;
    }

    public function getOrigin()
    {
        return $this->destinations[0];
    }

    public function getFinalDestination()
    {
        return $this->destinations[count($this->destinations) - 1];
    }

    public function getCost()
    {
        return array_reduce($this->destinations, function ($sum, $destination) {
            return $sum + $destination->getCost();
        }, 0);
    }

    public function fullPath()
    {
        $fullPath = array_reduce($this->destinations, function ($fullPath, $destination) {
            return $fullPath . ',' . $destination->getLocationCode();
        }, '');

        return trim($fullPath, ',');
    }
}
