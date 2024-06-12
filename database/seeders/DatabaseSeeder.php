<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Jabatan;
use App\Models\KategoriBarang;
use App\Models\Mahasiswas;
use App\Models\Prodi;
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

        User::create([
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => '1',
            'id_user' => Uuid::uuid4(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        $kategori = ['Monitor', 'Keyboard', 'Personal Komputer', 'SSD'];
        $prodi = [
            'TRPL' => 'Teknologi Rekayasa Perangkat Lunak',
            'MI' => 'Manajemen Informatika',
            'TeKom' => 'Teknologi Komputer',
            'AM' => 'Animasi'
        ];
        $jabatan = ['Staf', 'Kepala Labor', 'Dosen Pengajar', 'Kajur', 'Kaprodi'];

        for ($i = 0; $i <= 3; $i++) {
            KategoriBarang::create([
                'nama_kategori_barang' => $kategori[$i]
            ]);
        }

        for ($i = 0; $i < count($jabatan); $i++) {
            Jabatan::create([
                'jabatan' => $jabatan[$i]
            ]);
        }

        foreach ($prodi as $key => $value) {
            Prodi::create([
                'code_prodi' => $key,
                'nama_prodi' => $value
            ]);
        }

        Barang::factory(50)->create();
        Mahasiswas::factory(10)->create();
        Dosen::factory(20)->create();
    }
}