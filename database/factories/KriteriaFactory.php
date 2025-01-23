<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kriteria' => fake()->unique()->name(),
            'bobot' => fake()->randomFloat(2, 0, 1),
            'jenis_kriteria' => fake()->randomElement(['benefit', 'cost']),
        ];
    }
}
