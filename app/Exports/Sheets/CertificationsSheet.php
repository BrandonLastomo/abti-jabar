<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\UserCertification;
use Illuminate\Support\Collection;

class CertificationsSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $certs = UserCertification::where('user_id', $this->user->id)->get();
        
        return $certs->map(function ($cert) {
            return [
                $cert->certification_name,
                $cert->certification_type,
                $cert->certification_grade,
                $cert->court_type,
                $cert->competition_level,
                $cert->event_role,
                $cert->location,
                $cert->issued_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Sertifikasi',
            'Jenis Sertifikasi',
            'Tingkat / Grade',
            'Jenis Lapangan',
            'Tingkat Kompetisi',
            'Peran (Role)',
            'Lokasi Penerbitan',
            'Tanggal Terbit'
        ];
    }

    public function title(): string
    {
        return 'Sertifikasi';
    }
}
