<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\User;

class UserDatasExport implements WithMultipleSheets
{
    use Exportable;

    protected $user;
    protected $exports;

    public function __construct(User $user, array $exports)
    {
        $this->user = $user;
        $this->exports = $exports;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        if (in_array('profile', $this->exports)) {
            $sheets[] = new Sheets\GeneralProfileSheet($this->user);
        }
        if (in_array('identity', $this->exports)) {
            $sheets[] = new Sheets\IdentityDocumentSheet($this->user);
        }
        if (in_array('education', $this->exports)) {
            $sheets[] = new Sheets\EducationDocumentSheet($this->user);
        }
        if (in_array('team_experience', $this->exports)) {
            $sheets[] = new Sheets\TeamExperienceSheet($this->user);
        }
        if (in_array('event_experience', $this->exports)) {
            $sheets[] = new Sheets\EventExperienceSheet($this->user);
        }
        if (in_array('certifications', $this->exports)) {
            $sheets[] = new Sheets\CertificationsSheet($this->user);
        }

        return $sheets;
    }
}
