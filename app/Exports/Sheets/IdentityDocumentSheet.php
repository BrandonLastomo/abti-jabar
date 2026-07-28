<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\IdentityDocument;
use Illuminate\Support\Collection;

class IdentityDocumentSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $doc = IdentityDocument::where('user_id', $this->user->id)->first();
        
        return new Collection([
            [
                $doc->national_id_number ?? '-',
                $doc->family_card_number ?? '-',
                $doc->birth_certificate_number ?? '-',
                $doc->child_identity_card_number ?? '-',
                $doc->bpjs_number ?? '-',
                $doc->private_insurance_number ?? '-',
                $doc->under_16_integrity_pact_name ?? '-',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'No. KTP',
            'No. Kartu Keluarga',
            'No. Akta Kelahiran',
            'No. KIA',
            'No. BPJS',
            'No. Asuransi Swasta',
            'Nama Penandatangan Pakta Integritas (U16)'
        ];
    }

    public function title(): string
    {
        return 'Dokumen Identitas';
    }
}
