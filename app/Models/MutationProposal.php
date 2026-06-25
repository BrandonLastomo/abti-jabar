<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutationProposal extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'parental_consent_path',
        'withdrawal_letter_path',
        'mutation_memo_path',
        'integrity_pact_path',
        'admin_notes',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
