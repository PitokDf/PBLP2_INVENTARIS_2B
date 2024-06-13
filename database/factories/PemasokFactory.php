<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemasok>
 */
class PemasokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->company,
            'alamat' => fake()->address,
            'kode_pos' => fake()->postcode,
            'kota' => fake()->city,
            'no_hp' => fake()->bothify('08##########')
        ];
    }
}