<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StatusCode;
use App\Http\Requests\WindRequest;
use App\HTTP\Resources\Wind;
use App\Library\Services\Contracts\WeatherServiceInterface;
use Exception;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    /**
     * Get wind
     *
     * @param WindRequest $request
     * @param int $zipCode
     * @param WeatherServiceInterface $weatherService
     * @return Json Response
     */
    public function wind(WindRequest $request, WeatherServiceInterface $weatherService)
    {
        $validated = $request->validated();

        // TODO: Expand error handling to provide better consumer experience
        try {
            $wind = $weatherService->getWindByZipCode($validated['zipcode']);
        } catch (Exception $e) {
            return response()->json(
                ['message' => StatusCode::getMessageForCode(StatusCode::HTTP_SERVICE_UNAVAILABLE)],
                StatusCode::getMessageForCode(StatusCode::HTTP_SERVICE_UNAVAILABLE),
                ['Content-Type' => 'application/json']
            );
        }

        return response()->json(
            new Wind($wind),
            StatusCode::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
