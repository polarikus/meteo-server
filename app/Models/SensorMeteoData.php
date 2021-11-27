<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorMeteoData extends Model
{
    use HasFactory;

    protected $table = 'sensors_meteo_data';

    protected $fillable = [
        'device_id', 'temperature', 'humidity'
    ];

}
