<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {   
        
        $this->call(AdminSeeder::class);

            User::create([
                'name' => 'Syarif',
                'email' => 'syarifroma@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);
            User::create([
                'name' => 'Brian',
                'email' => 'brianlucky1708@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);
            User::create([
                'name' => 'Amelia',
                'email' => 'ameliafs842@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);
            User::create([
                'name' => 'Bumi',
                'email' => 'iimuub05@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);
            User::create([
                'name' => 'cipa',
                'email' => 'cipa@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);
            User::create([
                'name' => 'Nisa',
                'email' => 'febrianur425@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'konselor',
            ]);User::create([
                'name' => 'Naja',
                'email' => 'ainunnaja942@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'mahasiswa',
            ]);
    } 
}
