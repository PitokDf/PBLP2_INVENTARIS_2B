<?php

namespace Database\Factories;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswas>
 */
class MahasiswasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prodis = Prodi::pluck('code_prodi')->toArray();
        return [
            'nama' => fake()->name,
            'nim' => fake()->unique()->bothify('##1108####'),
            'code_prodi' => fake()->randomElement($prodis),
            'angkatan' => fake()->numberBetween(2015, 2023),
            'ipk' => fake()->randomFloat(2, 2.00, 4.00)
        ];
    }
}