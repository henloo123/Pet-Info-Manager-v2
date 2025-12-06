<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'species' => $this->faker->randomElement(['Dog', 'Cat', 'Bird', 'Other']),
            'breed' => $this->faker->word(),
            'date_of_birth' => $this->faker->date(),
            'weight' => $this->faker->randomFloat(2, 0.5, 50),
            'image' => null,
        ];
    }
}
