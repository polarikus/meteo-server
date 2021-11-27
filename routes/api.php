<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SensorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('test', function (Request $request){
    return response()->json([
        "sensor_data" => $request->all(),
        "serial_number" => $request->header('X-serial-number')
    ]);
});

Route::middleware(['auth:sanctum'])
    ->prefix('sensor')
    ->group(function (){
        Route::post('meteo-data', [SensorController::class, 'putMeteoData']);
        Route::patch('meteo-data', [SensorController::class, 'pushOnline']);
        Route::post('meteo/new-sensor',[SensorController::class, 'addSensor']);
    });

Route::prefix('reports')
    ->group(function (){
        Route::prefix('meteo')
            ->group(function (){
                Route::get('sensor-desc/{serialNumber}', [SensorController::class, 'getSesorDesc']);
                Route::get('sensor-stat/{serialNumber}/{type}', [ReportsController::class, 'graphData']);
            });
    });
