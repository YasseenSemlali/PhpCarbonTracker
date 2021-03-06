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
            'name'=> 'first user',
            'email'=> 'first@email.com',
            'password'=> Hash::make('password'),
            'latitude'=> 45.48576075,
            'longitude'=> -73.55347128718986,
            'fuel_type'=> 'diesel',
            'fuel_consumption' => 12,
            ]);
            
        User::create([
            'name'=> 'Jane Doe',
            'email'=> 'jd@email.com',
            'password'=> Hash::make('qwerty12'),
            'latitude'=> 45.513420,
            'longitude'=> -73.571020,
            'fuel_type'=> 'gasoline',
            'fuel_consumption' => 8,
            ]);
            
        User::create([
            'name'=> 'John Doe',
            'email'=> 'doe@email.com',
            'password'=> Hash::make('qwerty34'),
            'latitude'=> 45.519520,
            'longitude'=> -73.609512,
            'fuel_type'=> 'electric',
            'fuel_consumption' => 0,
            ]);
            
            
    }
}
