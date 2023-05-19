<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Briedis',
            'email' => 'briedis@gmail.com',
            'role' => 1,
            // briedis bus adminas
            'password' => Hash::make('123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Bebras',
            'email' => 'bebras@gmail.com',
            'role' => 10,
            // bebras-klientas
            'password' => Hash::make('123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Koshkis',
            'email' => 'koshkis@gmail.com',
            'role' => 10,
            // bebras-klientas
            'password' => Hash::make('123'),
        ]);
    }
}