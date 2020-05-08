<?php

namespace App\Library\Services\Contracts;

Interface WeatherServiceInterface
{
    /**
     * Get weather by zipcode
     *
     * @param int $zipCode
     * @return App\Models\Weather
     */
    public function getWeatherByZipCode(int $zipCode);

    /**
     * Get wind by zipcode
     *
     * @param int $zipCode
     * @return App\Models\Wind
     */
    public function getWindByZipCode(int $zipCode);
}