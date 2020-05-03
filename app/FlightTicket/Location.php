<?php

/**
 *
 */
class Location
{
    protected $code;
    protected $destinations = [];

    function __construct(string $code, array $destinations = [])
    {
        $this->code = $code;
        $this->destinations = $destinations;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
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
}
