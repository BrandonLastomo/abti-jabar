<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 week', '+1 month');
        return [
            'name' => 'Kejuaraan ' . $this->faker->city,
            'level' => $this->faker->randomElement([
                'provincial',
                'national',
                'international',
            ]),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => (clone $start)->modify('+3 days')->format('Y-m-d'),
            'place' => 'GOR ' . $this->faker->city,
            'status' => 'upcoming',
        ];
    }
}
