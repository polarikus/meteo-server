<?php

namespace App\Http\Controllers;

use App\Http\Requests\SensorDataRequest;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function getSesorDesc($serialNumber)
    {
        $sensor = Device::where('serial_number', '=', $serialNumber);
        $sensor->first()->loadMissing('last_online', 'last_meteo_data');
        $last_online = Carbon::create($sensor->first()->last_online->first()->last_online)->toISOString();
        $last_data = $sensor->first()->last_meteo_data->first()->toArray();
        $result = $sensor->first()->toArray();
        $result['last_online'] = $last_online;
        $result['last_meteo_data'] = $last_data;

        return response()->json($result);
    }

    public function putMeteoData(SensorDataRequest $request)
    {
        $validData = (object)$request->validationData();

        if ($request->user()->findDevice($validData->serial_number)->add_meteo_data(
            $validData->temperature,
            $validData->humidity
        )){
            return response('', 201);
        }
            return response()->json($request->validationData()['temperature'],500);
    }

    public function pushOnline(SensorDataRequest $request)
    {
        $serialNumber = $request->validationData()['serial_number'];
        $device = $request->user()->findDevice($serialNumber);
        return response()->json(['result' => $device->update_online()]);
    }

    public function addSensor(Request $request)
    {

        $data = [
            'serial_number' => $request->header('X-serial-number'),
            'chip' => $request->header('X-chip-model'),
            'rev' => $request->header('X-chip-rev')
        ];

        $data = Validator::make($data, [
            'serial_number' => 'required|unique:devices|max:255',
            'chip' => 'required',
            'rev' => 'required'
        ])->validate();
        if (!$request->user()->tokenCan('device:add-once')) {
            return response()
                ->json(['error' => 'Only one device can be added'], 403);
        }
        $request->user()->currentAccessToken()->abilities = ['device:auth'];
        $request->user()->currentAccessToken()->save();
        $device = Device::create($data);
        $request->user()->devices()->attach($device->id);

        return response('', 201);
    }
}
