<?php

namespace App\Factories;

use App\Library\Services\OpenWeatherService;
use App\Library\Cache\Contracts\CacheInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

class WeatherServiceFactory
{
    public static function build($type, $config, ClientInterface $client, CacheInterface $cache, SerializerInterface $serializer)
    {
        switch ($type) {
            case 'OpenWeatherMap':
                return new OpenWeatherService($config, $client, $cache, $serializer);
                break;
            default:
                return new OpenWeatherService($config, $client, $cache, $serializer);
                break;
        }
    }
}