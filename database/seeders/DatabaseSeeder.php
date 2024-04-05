<?php

namespace Database\Seeders;

use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Users::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => '1',
            'password' => bcrypt('12345678'),
        ]);
    }
}