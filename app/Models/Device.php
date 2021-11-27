<?php

namespace App\Models;

use App\Exceptions\UpdateSensorLastOnlineException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $touches = ['meteo_data', 'last_online', 'last_meteo_data'];

    protected $fillable = [
        'serial_number', 'chip', 'rev'
    ];

    public function meteo_data()
    {
        return $this->hasMany(SensorMeteoData::class);
    }


    public function getHourlyGraphData()
    {
        $from = Carbon::now()->floorHours()->toISOString();
        $to = Carbon::now()->floorHours()->addHour()->toISOString();
        return $this->hasMany(SensorMeteoData::class)
            ->whereBetween('created_at', [
                $from,
                $to
            ])->get();
    }

    public function last_meteo_data()
    {
        return $this->hasMany(SensorMeteoData::class)
            ->orderBy('created_at', 'desc')
            ->limit(1);
    }

    public function last_online()
    {
        return $this->hasOne(SensorLastOnline::class)->
        select(['last_online', 'device_id']);
    }

    public function update_online():bool
    {
        usleep(500000);
        if (!$this->hasOne(SensorLastOnline::class)->count()) {
            return (bool)$this->hasOne(SensorLastOnline::class)
                ->create([
                    'last_online' => Carbon::now()->timestamp
                ]);
        }

         if ($this->hasOne(SensorLastOnline::class)
            ->update([
                'last_online' => Carbon::now()->timestamp
            ])){
             return true;
         }

        throw new UpdateSensorLastOnlineException();
    }

    public function add_meteo_data(int $temperature, int $humidity)
    {
        $this->update_online();
        return $this->meteo_data()->create([
            'temperature' => $temperature,
            'humidity' => $humidity
        ]);
    }

}
