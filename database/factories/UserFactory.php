<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function admin(): static
    {
        return $this->state(fn () => [
            'name' => 'admin',
            'email' => 'admin@abti.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }

    public function definition(): array
    {
        return [
            // 'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => static::$password ??= Hash::make('password'),
            // 'remember_token' => Str::random(10),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement([
                'athlete',
                'coach',
                'GK coach',
                'technical director',
                'management team',
                'referee',
                'technical delegates',
                'volunteer',
            ]),
            'club_id' => rand(1, 3),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
