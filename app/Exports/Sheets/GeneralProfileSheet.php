<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\GeneralProfile;
use Illuminate\Support\Collection;

class GeneralProfileSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $profile = GeneralProfile::where('user_id', $this->user->id)->first();
        
        return new Collection([
            [
                $this->user->name,
                $this->user->email,
                $profile->gender ?? '-',
                $profile->birth_place ?? '-',
                $profile->birth_date ?? '-',
                $profile->phone ?? '-',
                $profile->address_by_id ?? '-',
                $profile->current_address ?? '-',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'No. Telepon',
            'Alamat Sesuai KTP',
            'Alamat Domisili'
        ];
    }

    public function title(): string
    {
        return 'Profil Umum';
    }
}
