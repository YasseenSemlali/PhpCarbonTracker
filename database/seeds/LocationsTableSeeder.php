<?php

use Illuminate\Database\Seeder;
use App\Locations;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Locations::create([
            'latitude' => 45.48576075,
             'longitude' =>  -73.55347128718986,
             'name' => 'Location 1',
             'user_id' => 1
            ]);
            
        Locations::create([
            'latitude' =>45.519520,
             'longitude' =>  -73.609512,
             'name' => 'Location 1',
             'user_id' => 2
            ]);
    }
}
