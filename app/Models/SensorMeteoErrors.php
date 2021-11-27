<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorMeteoErrors extends Model
{
    use HasFactory;

    protected $table = 'sensors_meteo_errors';

    protected $fillable = [
        'device_id', 'temperature', 'humidity'
    ];
}
