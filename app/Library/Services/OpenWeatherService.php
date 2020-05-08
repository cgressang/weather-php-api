<?php

namespace App\Library\Services;

use App\Library\Cache\Contracts\CacheInterface;
use App\Library\Services\Contracts\WeatherServiceInterface;
use App\Models\Weather;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Uri;
use Symfony\Component\Serializer\SerializerInterface;

class OpenWeatherService implements WeatherServiceInterface
{
    /* @var string */
    protected $apiKey;

    /* @var string */
    protected $endpoint;

    /* @var int */
    protected $cacheTime;

    /* @var GuzzleHttp\Client */
    protected $httpClient;

    /* @var Symfony\Component\Serializer\SerializerInterface */
    protected $serializer;

    /* @var App\Library\Cache\Contracts\CacheInterface */
    protected $cache;

    public function __construct($config, ClientInterface $client, CacheInterface $cache, SerializerInterface $serializer)
    {
        $this->apiKey = $config['api_key'];
        $this->endpoint = $this->createEndpoint($config['base_uri'], $config['api_version']);
        $this->cacheTime = $config['cache_time'];
        $this->httpClient = $client;
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    /**
     * Get weather by zipcode
     *
     * @param int $zipCode
     *
     * @return App\Models\Weather
     * @throws GuzzleException
     */
    public function getWeatherByZipCode(int $zipCode)
    {
        if ($this->cache->has('weather.' . $zipCode)) {
            $data = $this->cache->get('weather.' . $zipCode);
        } else {
            $parameters['zip'] = $zipCode;
            $parameters['appid'] = $this->apiKey;

            $response = $this->httpClient->request('GET', $this->endpoint, ['query' => $parameters]);
            $data = $response->getBody()->getContents();

            $this->cache->put('weather.' . $zipCode, $data, $this->cacheTime);
        }

        $weather = $this->serializer->deserialize($data, Weather::class, 'json');

        return $weather;
    }

    /**
     * Get wind by zipcode
     *
     * @param int $zipCode
     *
     * @return App\Models\Weather
     * @throws GuzzleException
     */
    public function getWindByZipCode(int $zipCode)
    {
        $weather = $this->getWeatherByZipCode($zipCode);

        return $weather->getWind();
    }

    /**
     * Create endpoint
     *
     * @param string $baseUri
     * @param string $apiVersion
     *
     * @return GuzzleHttp\Psr7\Uri
     */
    private function createEndpoint($baseUri, $apiVersion)
    {
        return new Uri($baseUri . $apiVersion . '/weather');
    }
}