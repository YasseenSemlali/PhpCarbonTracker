<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
         $this->call(TripsTableSeeder::class);
=======
        $this->call(UsersTableSeeder::class);
        $this->call(TripsTableSeeder::class);
>>>>>>> 708c4a66f0cd6278e6758724278ed1fd1b886f74
    }
}
