<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use Illuminate\Support\Str;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {

            Kegiatan::create([
                'name'  => 'Kegiatan Ke-' . $i,
                'slug'  => Str::slug('Kegiatan Ke-' . $i),
                'desc'  => 'Deskripsi kegiatan ke-' . $i,
                'date'  => now()->subDays($i),
                'image' => null,
            ]);

        }
    }
}
