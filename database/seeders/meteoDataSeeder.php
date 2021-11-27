<?php

namespace Database\Seeders;

use App\Models\SensorMeteoData;
use Illuminate\Database\Seeder;

class meteoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SensorMeteoData::factory()->count(50)->create();
    }
}
