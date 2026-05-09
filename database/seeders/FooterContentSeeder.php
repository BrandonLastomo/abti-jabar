<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterContent;

class FooterContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Brand Section
            [
                'key'   => 'logo',
                'label' => 'Logo Footer',
                'value' => 'img/mainlogo.avif',
                'type'  => 'image',
                'sort_order' => 1,
            ],
            [
                'key'   => 'org_name',
                'label' => 'Nama Organisasi',
                'value' => 'ABTI Jawa Barat',
                'type'  => 'text',
                'sort_order' => 2,
            ],
            [
                'key'   => 'org_description',
                'label' => 'Deskripsi Organisasi',
                'value' => 'Asosiasi Bola Tangan Indonesia<br>Provinsi Jawa Barat',
                'type'  => 'textarea',
                'sort_order' => 3,
            ],

            // Navigation Column 1 - Organisasi
            [
                'key'   => 'nav_col_1_title',
                'label' => 'Judul Kolom Navigasi 1',
                'value' => 'Organisasi',
                'type'  => 'text',
                'sort_order' => 4,
            ],
            [
                'key'   => 'nav_col_1_links',
                'label' => 'Link Kolom Navigasi 1',
                'value' => json_encode([
                    ['text' => 'Tentang Kami', 'url' => 'tentang-kami.html'],
                    ['text' => 'Program Kerja', 'url' => 'program-kerja.html'],
                    ['text' => 'Profile Tim', 'url' => 'profile.html'],
                ]),
                'type'  => 'json',
                'sort_order' => 5,
            ],

            // Navigation Column 2 - Informasi
            [
                'key'   => 'nav_col_2_title',
                'label' => 'Judul Kolom Navigasi 2',
                'value' => 'Informasi',
                'type'  => 'text',
                'sort_order' => 6,
            ],
            [
                'key'   => 'nav_col_2_links',
                'label' => 'Link Kolom Navigasi 2',
                'value' => json_encode([
                    ['text' => 'Event', 'url' => 'event.html'],
                    ['text' => 'Database', 'url' => 'database.html'],
                    ['text' => 'Galeri', 'url' => 'gallery.html'],
                    ['text' => 'Arsip', 'url' => 'archives.html'],
                ]),
                'type'  => 'json',
                'sort_order' => 7,
            ],

            // Contact Column
            [
                'key'   => 'contact_title',
                'label' => 'Judul Kolom Kontak',
                'value' => 'Kontak',
                'type'  => 'text',
                'sort_order' => 8,
            ],
            [
                'key'   => 'contact_email',
                'label' => 'Email',
                'value' => 'sekretariat@abtijabar.or.id',
                'type'  => 'text',
                'sort_order' => 9,
            ],
            [
                'key'   => 'contact_phone',
                'label' => 'Telepon',
                'value' => '+62 22 0000 0000',
                'type'  => 'text',
                'sort_order' => 10,
            ],
            [
                'key'   => 'contact_address',
                'label' => 'Alamat',
                'value' => 'Bandung, Jawa Barat',
                'type'  => 'text',
                'sort_order' => 11,
            ],

            // Copyright
            [
                'key'   => 'copyright',
                'label' => 'Teks Copyright',
                'value' => '© 2026 Asosiasi Bola Tangan Indonesia – Provinsi Jawa Barat',
                'type'  => 'text',
                'sort_order' => 12,
            ],
        ];

        foreach ($items as $item) {
            FooterContent::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
