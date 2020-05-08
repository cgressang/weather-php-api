<?php

use App\Http\Controllers\StatusCode;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'API\v1',
    'prefix' => 'v1',
], function ($router) {
    Route::get('wind/{zipcode}', 'WeatherController@wind');
});

Route::fallback(function() {
    return response()->json(['message' => StatusCode::getMessageForCode(StatusCode::HTTP_NOT_FOUND)], StatusCode::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
});