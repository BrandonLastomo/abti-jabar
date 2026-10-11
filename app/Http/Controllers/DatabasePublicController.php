<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DatabasePublicController extends Controller
{
    private function getRingkasanUrl(): string
    {
        $id = config('services.google_sheet_sdm.id', '1wxzvEAs1LhDr-lMGu34M8l3r-xBZzTLxVq4vyqPeDBA');
        $gid = config('services.google_sheet_sdm.gid_ringkasan', '0');
        return "https://docs.google.com/spreadsheets/d/{$id}/export?format=csv&gid={$gid}&_t=" . time();
    }

    private function getDetailUrl(): string
    {
        $id = config('services.google_sheet_sdm.id', '1wxzvEAs1LhDr-lMGu34M8l3r-xBZzTLxVq4vyqPeDBA');
        $gid = config('services.google_sheet_sdm.gid_detail', '1402167587');
        return "https://docs.google.com/spreadsheets/d/{$id}/export?format=csv&gid={$gid}&_t=" . time();
    }

    public function index(Request $request)
    {
        // Support manual refresh via query parameter (e.g., /database?refresh=1 or "Sync Sheet" button)
        if ($request->has('refresh')) {
            Cache::forget('abti_sdm_database_page');
        }

        $data = Cache::remember('abti_sdm_database_page', now()->addMinutes(5), function () {
            return [
                'overviewCards' => $this->fetchRingkasanData(),
                'details' => $this->fetchDetailData(),
            ];
        });

        $overviewCards = $data['overviewCards'];
        $panes = $data['details']['panes'];
        $titles = $data['details']['titles'];

        return view('database', compact('overviewCards', 'panes', 'titles'));
    }

    private function fetchRingkasanData(): array
    {
        try {
            $url = $this->getRingkasanUrl();
            $response = Http::timeout(8)->get($url);
            if (!$response->successful()) {
                return $this->getDefaultOverviewCards();
            }

            $lines = preg_split('/\r\n|\r|\n/', trim($response->body()));
            $cards = [];

            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $row = str_getcsv($line);

                // Handle leading empty column if present
                $colOffset = (trim($row[0] ?? '') === '' && count($row) > 4) ? 1 : 0;

                $kategori = trim($row[$colOffset] ?? '');
                $tipe = trim($row[$colOffset + 1] ?? '');
                $rawJumlah = trim($row[$colOffset + 2] ?? '');
                $deskripsi = trim($row[$colOffset + 3] ?? '');

                if ($kategori === '' || strtolower($kategori) === 'kategori' || strtolower($kategori) === 'total') {
                    continue;
                }

                $jumlah = (int) preg_replace('/[^0-9]/', '', $rawJumlah);

                $cards[] = [
                    'title' => $kategori,
                    'type' => $tipe ?: 'Umum',
                    'count' => $jumlah,
                    'description' => $deskripsi,
                ];
            }

            return !empty($cards) ? $cards : $this->getDefaultOverviewCards();
        } catch (\Throwable $e) {
            report($e);
            return $this->getDefaultOverviewCards();
        }
    }

    private function fetchDetailData(): array
    {
        try {
            $url = $this->getDetailUrl();
            $response = Http::timeout(8)->get($url);
            if (!$response->successful()) {
                return $this->getDefaultPanesAndTitles();
            }

            $lines = preg_split('/\r\n|\r|\n/', trim($response->body()));
            $panes = [];
            $titles = [];

            $roleKeyMap = [
                'atlet' => 'atlet',
                'pelatih' => 'pelatih',
                'pelatih gk' => 'pelatihgk',
                'technical director' => 'td',
                'tim manajemen' => 'manajemen',
                'wasit' => 'wasit',
                'technical delegates' => 'delegates',
                'volunteer' => 'volunteer',
            ];

            $isHeader = true;
            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $row = str_getcsv($line);
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                if (count($row) < 4) continue;
                $peran = trim($row[0] ?? '');
                $wilayah = trim($row[1] ?? '');
                $jumlah = (int) preg_replace('/[^0-9]/', '', $row[2] ?? '0');
                $status = trim($row[3] ?? '');

                if ($peran === '') continue;

                $normalized = strtolower($peran);
                $key = $roleKeyMap[$normalized] ?? Str::slug($normalized);

                if (!isset($titles[$key])) {
                    $titles[$key] = $peran;
                    $panes[$key] = [];
                }

                $statusLower = strtolower($status);
                $statusType = (str_contains($statusLower, 'aktif') || str_contains($statusLower, 'ok')) ? 'ok' : 'warn';

                $panes[$key][] = [$wilayah, $jumlah, $statusType, $status];
            }

            if (empty($panes)) {
                return $this->getDefaultPanesAndTitles();
            }

            return ['panes' => $panes, 'titles' => $titles];
        } catch (\Throwable $e) {
            report($e);
            return $this->getDefaultPanesAndTitles();
        }
    }

    private function getDefaultOverviewCards(): array
    {
        return [
            ['title' => 'Atlet', 'type' => 'Core', 'count' => 128, 'description' => 'Atlet terdaftar aktif'],
            ['title' => 'Coaching & Tech', 'type' => 'Teknis', 'count' => 34, 'description' => 'Pelatih + Pelatih GK + TD'],
            ['title' => 'Match Officials', 'type' => 'Regulasi', 'count' => 22, 'description' => 'Wasit + Delegates'],
            ['title' => 'Management & Support', 'type' => 'Ops', 'count' => 60, 'description' => 'Manajemen + Volunteer'],
        ];
    }

    private function getDefaultPanesAndTitles(): array
    {
        return [
            'panes' => [
                'atlet' => [['Bandung', 42, 'ok', 'Aktif'], ['Bekasi', 31, 'ok', 'Aktif'], ['Bogor', 9, 'warn', 'Perlu Verifikasi']],
                'pelatih' => [['Bandung', 12, 'ok', 'Aktif'], ['Depok', 7, 'warn', 'Perlu Update']],
                'pelatihgk' => [['Bandung', 3, 'ok', 'Aktif']],
                'td' => [['Jawa Barat', 1, 'ok', 'Aktif']],
                'manajemen' => [['Bandung', 10, 'ok', 'Aktif']],
                'wasit' => [['Bandung', 6, 'ok', 'Aktif']],
                'delegates' => [['West', 4, 'ok', 'Aktif']],
                'volunteer' => [['Event 01', 18, 'ok', 'Aktif']],
            ],
            'titles' => [
                'atlet' => 'Atlet',
                'pelatih' => 'Pelatih',
                'pelatihgk' => 'Pelatih GK',
                'td' => 'Technical Director',
                'manajemen' => 'Tim Manajemen',
                'wasit' => 'Wasit',
                'delegates' => 'Technical Delegates',
                'volunteer' => 'Volunteer',
            ]
        ];
    }
}
