<?php

namespace App\Providers;

use App\Factories\WeatherServiceFactory;
use App\Library\Cache\SimpleCache;
use App\Library\Services\Contracts\WeatherServiceInterface;
use App\Library\Services\OpenWeatherService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WeatherServiceInterface::class, function ($app) {
            $default = $app->config['weather.default'];
            $config = $app->config['weather.services'][$default];

            $cache = new SimpleCache($app['cache']);

            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoders);

            return WeatherServiceFactory::build($default, $config, new Client(), $cache, $serializer);
        });
    }
}
