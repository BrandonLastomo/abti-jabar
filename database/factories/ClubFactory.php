<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city . ' Handball Club',
            'city' => $this->faker->city,
            'founded_year' => $this->faker->numberBetween(2010, 2022),
            'status' => $this->faker->randomElement(['member', 'guest']),
        ];
    }
}
