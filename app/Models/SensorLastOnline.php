<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorLastOnline extends Model
{
    use HasFactory;

    protected $table = 'sensors_last_online';

    protected $fillable = [
        'device_id', 'last_online'
    ];

    public $timestamps = false;

}
