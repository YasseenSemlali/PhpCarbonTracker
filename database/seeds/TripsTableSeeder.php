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
            'start_lattitude' => 75,
             'start_longtitude' => -97,
             'end_lattitude' => 76,
             'end_longtitude' => -96,
              'mode' => 'car',
             'engine' => 'diesel',
             'travelTime' => 130,
             'distance' => 123,
             'co2emissions' => 19,
             'user_id' => 1
            ]);
        Trip::create([
            'start_lattitude' => 65,
             'start_longtitude' => -56,
             'end_lattitude' => 54,
             'end_longtitude' => -34,
             'mode' => 'bicycle',
             'travelTime' => 1320,
             'distance' => 300,
             'co2emissions' => 2.4,
             'user_id' => 1
            ]);

    }
}
