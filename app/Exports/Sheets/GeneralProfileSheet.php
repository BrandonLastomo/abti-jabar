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
                optional($profile)->gender ?? '-',
                optional($profile)->birth_regency ?? '-',
                optional($profile)->birth_province ?? '-',
                optional($profile)->birth_date ?? '-',
                optional($profile)->phone ?? '-',
                optional($profile)->address_by_id ?? '-',
                optional($profile)->current_address ?? '-',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Jenis Kelamin',
            'Tempat Lahir (Kab/Kota)',
            'Tempat Lahir (Provinsi)',
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
