<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Darrel Fawwaz Agathon',
            'username' => 'darrelfaa',
            'email' => 'darrelfa19@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'photo' => 'https://i.imgur.com/r9iDcZv.jpeg',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Yuji Nakamura',
            'username' => 'yuji_nakamura',
            'email' => 'yuji@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'photo' => 'https://i.imgur.com/49sHwfT.jpeg',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'photo' => 'https://i.imgur.com/wlbKztI.jpeg',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);   

        User::factory(9)->create();
    }
}
