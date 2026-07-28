<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\EventExperience;
use Illuminate\Support\Collection;

class EventExperienceSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $experiences = EventExperience::where('user_id', $this->user->id)->get();
        
        return $experiences->map(function ($exp) {
            return [
                $exp->event_name,
                $exp->event_city,
                $exp->team_name,
                $exp->event_role,
                $exp->court_type,
                $exp->event_format,
                $exp->competition_level,
                $exp->participant_scope,
                $exp->age_category,
                $exp->result,
                $exp->event_start_date,
                $exp->event_end_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Event',
            'Kota Event',
            'Nama Tim',
            'Peran di Event',
            'Jenis Lapangan',
            'Format Event',
            'Tingkat Kompetisi',
            'Cakupan Peserta',
            'Kategori Usia',
            'Hasil / Prestasi',
            'Tanggal Mulai',
            'Tanggal Selesai'
        ];
    }

    public function title(): string
    {
        return 'Pengalaman Event';
    }
}
