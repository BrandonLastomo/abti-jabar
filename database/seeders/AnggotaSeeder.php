<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Str;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Bandung',
            'Bekasi',
            'Karawang',
            'Bogor',
            'Depok',
            'Cirebon',
            'Sukabumi',
            'Tasikmalaya',
            'Garut',
            'Subang'
        ];

        foreach ($data as $city) {
            Anggota::create([
                'city'      => $city,
                'lead_name' => 'Ketua ' . $city,
                'sec_name'  => 'Sekretaris ' . $city,
                'email'     => strtolower($city) . '@abti.or.id',
                'link'      => 'https://abti.or.id/' . strtolower($city),
                'logo'      => null,
                'slug'      => Str::slug($city . '-ketua-' . $city),
            ]);
        }
    }
}
