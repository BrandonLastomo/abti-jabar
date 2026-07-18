<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\User;
use App\Models\Event;

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
        $this->call([
            RoleSeeder::class,
            FooterContentSeeder::class,
            AnggotaSeeder::class,

            KegiatanSeeder::class,
            SponsorSeeder::class,
        ]);
    }
}
