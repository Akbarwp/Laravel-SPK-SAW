<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubKriteria>
 */
class SubKriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_kriteria' => fake()->unique()->name(),
            'bobot' => fake()->numberBetween(1,5),
            'kriteria_id' => fake()->randomDigitNotNull(),
        ];
    }
}
