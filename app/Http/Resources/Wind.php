<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Wind extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'speed' => $this->speed,
            'direction' => $this->getCompassDirection($this->deg),
        ];
    }

    /**
     * Get Compass Direction
     *
     * @param mixed $degrees
     * @return string
     */
    private function getCompassDirection($degrees)
    {
        $tmp = round($degrees / 22.5);

        $directions = [
            'N',
            'NNE',
            'NE',
            'ENE',
            'E',
            'ESE',
            'SE',
            'SSE',
            'S',
            'SSW',
            'SW',
            'WSW',
            'W',
            'WNW',
            'NW',
            'NNW',
            'N',
        ];

        return $directions[$tmp];
    }
}
