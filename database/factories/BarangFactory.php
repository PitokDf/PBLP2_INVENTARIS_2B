<?php

namespace Database\Factories;

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
        return [
            'code_barang' => fake()->ean13(),
            'nama_barang' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 100),
            'id_kategory' => mt_rand(1, 4),
            'posisi' => fake()->sentence(),
            'photo' => fake()->imageUrl()
        ];
    }
}