<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Committee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test student user
        User::create([
            'matric_id' => '2212345',
            'name' => 'Muhammad Ali',
            'email' => 'muhammad@student.iium.edu.my',
            'password' => Hash::make('password123'),
            'phone' => '012-345-6789',
            'mahallah' => 'Mahallah Uthman',
            'profile_photo' => null,
        ]);
        
        User::create([
            'matric_id' => '2234321',
            'name' => 'Nur Aisyah',
            'email' => 'aisyah@student.iium.edu.my',
            'password' => Hash::make('password123'),
            'phone' => '012-343-2311',
            'mahallah' => 'Mahallah Safiya',
            'profile_photo' => null,
        ]);

        // Create test committees with committee_id
        Committee::create([
            'committee_id' => 'COM001',
            'club_name' => 'Entrepreneurship Club',
            'email' => 'entrepreneurship@iium.edu.my',
            'password' => Hash::make('committee123'),
            'description' => 'Promoting entrepreneurship among students',
        ]);

        Committee::create([
            'committee_id' => 'COM002',
            'club_name' => 'Swimming Club',
            'email' => 'swimming@iium.edu.my',
            'password' => Hash::make('committee123'),
            'description' => 'Swimming and water sports club',
        ]);
        Committee::create([
            'committee_id' => 'COM003',
            'club_name' => 'Arts Club',
            'email' => 'ArtsKae@iium.edu.my',
            'password' => Hash::make('committee123'),
            'description' => 'Everything is arts',
        ]);
    }
}