<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory(10)->create();
        User::create([
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => '1',
            'id_user' => Uuid::uuid4(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        $kategori = ['Monitor', 'Keyboard', 'Personal Komputer', 'SSD'];

        for ($i = 0; $i <= 3; $i++) {
            KategoriBarang::create([
                'nama_kategori_barang' => $kategori[$i]
            ]);
        }

        Barang::factory(50)->create();
    }
}