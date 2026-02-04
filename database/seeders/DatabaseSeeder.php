<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\User;
use App\Models\Event;
use App\Models\BallMatch;
use App\Models\Highlight;
use App\Models\Livestream;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Club::factory()->count(3)->create();

        User::factory()->admin()->create();
        User::factory()->count(3)->create();

        Event::factory()->count(3)->create();
        BallMatch::factory()->count(3)->create();
        Highlight::factory()->count(3)->create();
        Livestream::factory()->count(3)->create();
    }
}
