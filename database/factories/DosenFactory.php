<?php

namespace Database\Factories;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jabatan = Jabatan::pluck('id')->toArray();
        return [
            "name" => fake()->name,
            "nip" => fake()->bothify('##################'),
            "jabatan_id" => fake()->randomElement($jabatan),
            "phone_number" => fake()->unique()->bothify('08##########'),
            "email" => fake()->unique()->safeEmail
        ];
    }
}