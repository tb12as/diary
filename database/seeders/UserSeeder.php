<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Syafiq Afifuddin',
        	'email' => 'syafiqafifuddin59@gmail.com',
        	'password' => bcrypt('1234'),
        ]);	
        // admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'level' => 1,
            'password' => bcrypt('1234'),
        ]); 
    }
}
