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
             'name' => '300 Rue Bridge, MONTREAL QC H3K 2C3',
             'user_id' => 1
            ]);
    }
}
