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
            'lattitude' => 45.48576075,
             'longtitude' =>  -73.55347128718986,
             'name' => 'Location 1',
             'user_id' => 1
            ]);
            
        Locations::create([
            'lattitude' =>45.519520,
             'longtitude' =>  -73.609512,
             'name' => 'Location 1',
             'user_id' => 2
            ]);
    }
}
