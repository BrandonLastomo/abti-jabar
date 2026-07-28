<?php

namespace App\Traits;

use App\Models\DocumentVerification;

trait HasDocumentVerifications
{
    /**
     * Get all document verifications for the model.
     */
    public function documentVerifications()
    {
        return $this->morphMany(DocumentVerification::class, 'documentable');
    }

    /**
     * Record a new document upload / reset verification status.
     * 
     * @param string $fieldName The column name where the document path is stored.
     * @param int|null $userId The ID of the user who owns the document (null if it belongs to club).
     *                         If null, we can try to guess from the model's user_id or club's user_id.
     */
    public function recordDocumentUpload($fieldName, $userId = null)
    {
        if (!$userId) {
            $userId = $this->user_id ?? auth()->id();
        }

        $this->documentVerifications()->updateOrCreate(
            ['field_name' => $fieldName],
            [
                'user_id' => $userId,
                'status' => 'pending',
                'notes' => null,
                'verified_at' => null,
                'verified_by' => null,
            ]
        );
    }

    /**
     * Get the verification status for a specific field.
     *
     * @param string $fieldName
     * @return DocumentVerification|null
     */
    public function getDocumentVerification($fieldName)
    {
        return $this->documentVerifications()->where('field_name', $fieldName)->first();
    }
}
