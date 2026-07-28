<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\EducationDocument;
use Illuminate\Support\Collection;

class EducationDocumentSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $edu = EducationDocument::where('user_id', $this->user->id)->first();
        
        return new Collection([
            [
                optional($edu)->elementary_school_name ?? '-',
                optional($edu)->junior_high_school_name ?? '-',
                optional($edu)->senior_high_school_name ?? '-',
                optional($edu)->bachelor_university_name ?? '-',
                optional($edu)->masters_university_name ?? '-',
                optional($edu)->doctoral_university_name ?? '-',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama SD',
            'Nama SMP',
            'Nama SMA/SMK',
            'Nama Universitas (S1)',
            'Nama Universitas (S2)',
            'Nama Universitas (S3)'
        ];
    }

    public function title(): string
    {
        return 'Pendidikan';
    }
}
