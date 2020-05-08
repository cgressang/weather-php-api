<?php

namespace App\Models;

class Wind
{
    public $speed;

    public $deg;

    public function __construct($speed, $deg)
    {
        $this->speed = $speed;
        $this->deg = $deg;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setWind($speed)
    {
        $this->speed = $speed;
    }

    public function getDeg()
    {
        return $this->deg;
    }

    public function setDeg($deg)
    {
        $this->deg = $deg;
    }
}
