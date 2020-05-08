<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherTest extends TestCase
{
    public function testValidGetWindTest()
    {
        $response = $this->get('/api/v1/wind/89101');
        $response->assertStatus(200);
    }

    public function provideZipCodeData()
    {
        return [
            [9],
            [99],
            [999],
            [9999],
            [999999],
            ['rtgefs'],
        ];
    }

    /**
     * @dataProvider provideZipCodeData
     */
    public function testInvalidGetWindTest($zipCode)
    {
        $response = $this->get('/api/v1/wind/' . $zipCode);
        $response->assertStatus(400);
    }
}
