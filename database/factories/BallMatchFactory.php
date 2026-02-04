<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BallMatch>
 */
class BallMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Match ' . $this->faker->city . ' vs ' . $this->faker->city,
            'event_id' => rand(1, 3),
            'home_club_id' => rand(1, 3),
            'away_club_id' => rand(1, 3),
            'match_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'score_home' => 0,
            'score_away' => 0,
        ];
    }
}
