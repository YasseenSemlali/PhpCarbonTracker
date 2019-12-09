<?php

use Illuminate\Database\Seeder;
use App\Trip;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Trip::create([
            'start_latitude' => 75,
             'start_longitude' => -97,
             'end_latitude' => 76,
             'end_longitude' => -96,
              'mode' => 'car',
             'engine' => 'diesel',
             'travelTime' => 130,
             'distance' => 123,
             'co2emissions' => 5.8,
             'user_id' => 1
            ]);
            
        Trip::create([
            'start_latitude' => 65,
             'start_longitude' => -56,
             'end_latitude' => 54,
             'end_longitude' => -34,
             'mode' => 'bicycle',
             'travelTime' => 1320,
             'distance' => 300,
             'co2emissions' => 0,
             'user_id' => 1
            ]);

    }
}
