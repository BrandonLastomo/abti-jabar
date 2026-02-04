<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livestream>
 */
class LivestreamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Live Match ' . $this->faker->city,
            'event_id' => rand(1, 3),
            'match_id' => rand(1, 3),
            'stream_url' => 'https://youtube.com/live/' . $this->faker->uuid,
            'status' => 'upcoming',
            'started_at' => null,
            'ended_at' => null,
        ];
    }
}
