<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentVerification extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the owning documentable model.
     */
    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who owns the document.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who verified the document.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
