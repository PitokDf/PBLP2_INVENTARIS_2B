<?php

namespace Database\Factories;

use App\Models\Merk;
use App\Models\Pemasok;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $merk = Merk::pluck('id')->toArray();
        $pemasok = Pemasok::pluck('id')->toArray();
        return [
            'code_barang' => fake()->ean13(),
            'nama_barang' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 100),
            'id_kategory' => mt_rand(1, 4),
            'posisi' => fake()->sentence(),
            'photo' => fake()->imageUrl(),
            'merk_id' => fake()->randomElement($merk),
            'supplier_id' => fake()->randomElement($pemasok),
            'tanggal_masuk' => fake()->date(),
            'deskripsi' => fake()->sentence()
        ];
    }
}