<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BigNews;
use Illuminate\Support\Str;

class BigNewsSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {

            $title = "Big News $i";

            BigNews::create([
                'title'   => $title,
                'slug'    => Str::slug($title),
                'image'   => null,
                'content' => "Ini adalah isi konten untuk berita ke-$i. 
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]);
        }
    }
}
