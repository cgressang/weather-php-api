<?php

namespace App\Models;

class Weather
{
    /* @var App\Models\Wind */
    public $wind;

    public function __construct(Wind $wind)
    {
        $this->wind = $wind;
    }

    /**
     * Get wind
     *
     * @return App\Models\Wind
     */
    public function getWind()
    {
        return $this->wind;
    }

    /**
     * Set wind
     *
     * @param App\Models\Wind $wind
     */
    public function setWind(Wind $wind)
    {
        $this->wind = $wind;
    }
}
