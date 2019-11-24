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
        Trip::create(['created_at' => '2019-09-20 13:41:30',
                    'user_id' => '1',
                    'start_lattitude' =>45.4908788,
                    'start_longtitude' => -73.588405,
                    'end_lattitude' => 45.4908788,
                    'end_longtitude' => -73.588405,
                    'mode' =>'car',
                    'engine' => 'diesel',
                    'travelTime' =>634,
                    'distance' => 1345,
                    'co2emissions' => 0.385]);
    }
}
