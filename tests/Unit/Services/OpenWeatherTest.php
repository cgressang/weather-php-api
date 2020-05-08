<?php

namespace Tests\Unit\Services;

use App\Library\Cache\Contracts\CacheInterface as Cache;
use App\Library\Services\OpenWeatherService;
use App\Models\Weather;
use App\Models\Wind;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Tests\TestCase;

/**
 * @covers \App\Library\Services\OpenWeatherService
 */
class OpenWeatherTest extends TestCase
{
    public function provideGetWeatherByZipCodeData(): array
    {
        return [
            [
                [
                    'api_key' => 'foo',
                    'api_version' => '2',
                    'base_uri' => 'http://foo.com',
                    'cache_time' => '15',
                ],
                90803,
            ], [
                [
                    'api_key' => 'foo',
                    'api_version' => '2',
                    'base_uri' => 'http://foo.com',
                    'cache_time' => '15',
                ],
                90801,
            ],
        ];
    }

    /**
     * @covers ::getWeatherByZipCode
     *
     * @dataProvider provideGetWeatherByZipCodeData
     */
    public function testGetWeatherByZipCodeTest($config, $zipCode)
    {
        $mockWeatherData = $this->openWeatherMockData();

        $mock = new MockHandler([
            new Response(200, [], $mockWeatherData),
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mock)]);
        $mockCache = Mockery::mock(Cache::class);
        $mockSerializer = Mockery::mock(Serializer::class);

        $mockWeather = Mockery::mock(Weather::class);

        $service = new OpenWeatherService($config, $mockClient, $mockCache, $mockSerializer);

        $mockCache
            ->shouldReceive('has')
            ->with('weather.' . $zipCode)
            ->andReturn(null);

        $mockCache
            ->shouldReceive('put')
            ->with('weather.' . $zipCode, $mockWeatherData, $config['cache_time']);

        $mockSerializer
            ->shouldReceive('deserialize')
            ->with($mockWeatherData, Weather::class, 'json')
            ->andReturn($mockWeather);

        $service->getWeatherByZipCode($zipCode);
    }

    /**
     * @covers ::getWindByZipCode
     *
     * @dataProvider provideGetWeatherByZipCodeData
     */
    public function testGetWindByZipCodeTest($config, $zipCode)
    {
        $mockWeatherData = $this->openWeatherMockData();

        $mock = new MockHandler([
            new Response(200, [], $mockWeatherData),
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mock)]);
        $mockCache = Mockery::mock(Cache::class);
        $mockSerializer = Mockery::mock(Serializer::class);

        $mockWeather = Mockery::mock(Weather::class);
        $mockWind = Mockery::mock(Wind::class);

        $service = new OpenWeatherService($config, $mockClient, $mockCache, $mockSerializer);

        $mockCache
            ->shouldReceive('has')
            ->with('weather.' . $zipCode)
            ->andReturn(null);

        $mockCache
            ->shouldReceive('put')
            ->with('weather.' . $zipCode, $mockWeatherData, $config['cache_time']);

        $mockSerializer
            ->shouldReceive('deserialize')
            ->with($mockWeatherData, Weather::class, 'json')
            ->andReturn($mockWeather);

        $mockWeather
            ->shouldReceive('getWind')
            ->andReturn($mockWind);

        $service->getWindByZipCode($zipCode);
    }

    private function openWeatherMockData()
    {
        return json_encode([
            'coord' => [
                'lon' => -122.09,
                'lat' => 37.39,
            ],
            'weather' => [
                [
                    'id' => 500,
                    'main' => 'Rain',
                    'description' => 'light rain',
                    'icon' => '10d',
                ],
            ],
            'base' => 'stations',
            'main' => [
                'temp' => 280.44,
                'pressure' => 1017,
                'humidity' => 61,
                'temp_min' => 279.15,
                'temp_max' => 281.15,
            ],
            'visibility' => 12874,
            'wind' => [
                'speed' => 8.2,
                'deg' => 340,
                'gust' => 11.3,
            ],
            'clouds' => [
                'all' => 1,
            ],
            'dt' => 1519061700,
            'sys' => [
                'type' => 1,
                'id' => 392,
                'message' => 0.0027,
                'country' => 'US',
                'sunrise' => 1519051894,
                'sunset' => 1519091585,
            ],
            'id' => 0,
            'name' => 'Mountain View',
            'cod' => 200,
        ]);
    }
}
