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
                $cert->certification_name ?? '-',
                $cert->certification_number ?? '-',
                $cert->category ?? 'Handball',
                $cert->role ?? $cert->type ?? '-',
                $cert->course ?? '-',
                $cert->level ?? '-',
                $cert->number ?? '-',
                $cert->organizer ?? '-',
                $cert->date_of_issue ?? '-',
                $cert->regency ?? '-',
                $cert->province ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Sertifikasi',
            'Nomor Sertifikat / Lisensi',
            'Kategori',
            'Role',
            'Course / Detail',
            'Level',
            'Nomor (Disiplin)',
            'Penyelenggara',
            'Tanggal Terbit',
            'Kabupaten / Kota',
            'Provinsi'
        ];
    }

    public function title(): string
    {
        return 'Sertifikasi';
    }
}
