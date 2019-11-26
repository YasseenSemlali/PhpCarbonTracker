<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'id'=>1,
            'name'=> 'first user',
            'email'=> 'first@email.com',
            'password'=> Hash::make('password'),
            'lattitude'=> 74,
            'longtitude'=> -96,
            'fuel_type'=> 'diesel',
            'fuel_consumption' => 12,
            ]);
    }
}
