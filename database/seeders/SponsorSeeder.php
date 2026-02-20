<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            [
                'name' => 'KONI Jawa Barat',
                'link' => 'https://konijabar.or.id',
                'image' => null, // Nanti diisi manual via upload di dashboard
            ],
            [
                'name' => 'Bank BJB',
                'link' => 'https://www.bankbjb.co.id',
                'image' => null,
            ],
            [
                'name' => ' Specs Indonesia',
                'link' => 'https://specs.id',
                'image' => null,
            ],
            [
                'name' => 'Mizuno',
                'link' => 'https://mizuno.id',
                'image' => null,
            ],
            [
                'name' => 'Indofood',
                'link' => 'https://www.indofood.com',
                'image' => null,
            ],
        ];

        foreach ($sponsors as $sponsor) {
            Sponsor::create($sponsor);
        }
    }
}