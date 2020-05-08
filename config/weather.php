<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Open Weather
    |--------------------------------------------------------------------------
    |
    | OpenWeather requires an API key
    |
    */

    'default' => 'OpenWeatherMap',

    'services' => [
        'OpenWeatherMap' => [
            'api_key' => env('OPENWEATHERMAP_API_KEY', ''),
            'api_version' => '2.5',
            'base_uri' => 'http://api.openweathermap.org/data/',
            'cache_time' => '15' // minutes
        ],
    ],
];