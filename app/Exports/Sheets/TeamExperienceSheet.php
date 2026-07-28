<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\UserTeamExperience;
use Illuminate\Support\Collection;

class TeamExperienceSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $experiences = UserTeamExperience::where('user_id', $this->user->id)->get();
        
        return $experiences->map(function ($exp) {
            return [
                $exp->team_name,
                $exp->team_type,
                $exp->start_date,
                $exp->end_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Tim',
            'Tingkat / Jenis Tim',
            'Tanggal Mulai',
            'Tanggal Selesai'
        ];
    }

    public function title(): string
    {
        return 'Pengalaman Tim';
    }
}
