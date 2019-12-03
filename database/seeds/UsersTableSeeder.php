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
            'lattitude'=> 45.48576075,
            'longtitude'=> -73.55347128718986,
            'fuel_type'=> 'diesel',
            'fuel_consumption' => 12,
            ]);
            
        User::create([
            'id'=>2,
            'name'=> 'Jane Doe',
            'email'=> 'jd@email.com',
            'password'=> Hash::make('qwerty12'),
            'lattitude'=> 45.513420,
            'longtitude'=> -73.571020,
            'fuel_type'=> 'gasoline',
            'fuel_consumption' => 8,
            ]);
            
        User::create([
            'id'=>3,
            'name'=> 'John Doe',
            'email'=> 'doe@email.com',
            'password'=> Hash::make('qwerty34'),
            'lattitude'=> 45.519520,
            'longtitude'=> -73.609512,
            'fuel_type'=> 'electric',
            'fuel_consumption' => 0,
            ]);
            
            
    }
}
