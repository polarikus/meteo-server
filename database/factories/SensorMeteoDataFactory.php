<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\SensorMeteoData;
use Illuminate\Database\Eloquent\Factories\Factory;

class SensorMeteoDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = SensorMeteoData::class;

    public function definition()
    {
        $device = Device::all();
        $device = $device[$this->faker->numberBetween(0, $device->count() - 1)];
        return [
            'device_id' => $device->id,
            'temperature' => $this->faker->numberBetween(-20, 40),
            'humidity' => $this->faker->numberBetween(1, 100)
        ];
    }

    protected static function newFactory()
    {
        return meteoDataFactory::new();
    }
}
