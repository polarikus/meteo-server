<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function meteoSensor($serialNumber)
    {
        $device = Device::where('serial_number', '=', $serialNumber);
        if ($device->count() === 0){
            return view('welcome', ['err' => 'Девайс не найден', 'sn' => $serialNumber]);
        }
        return view('report-meteo-sensor', ['serial_number' => $serialNumber]);
    }

    public function graphData($serial_number, $type)
    {
        //dd(Carbon::now()->floorHours()->toISOString());
        $sensor = Device::where('serial_number', '=', $serial_number)->first();
        $data = $sensor->getHourlyGraphData();
        $toGraphArr = [
            'mins' => [],
            'temperature' => [],
            'humidity' => []
        ];
        foreach ($data as $datum){
            $toGraphArr['mins'][] .= Carbon::create($datum->created_at)->format('i');
            $toGraphArr['temperature'][] += (int)$datum->temperature;
            $toGraphArr['humidity'][] += (int)$datum->humidity;
        }
        return response()->json($toGraphArr);

    }
}
