<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\IdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserIdentityDocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $identity = IdentityDocument::firstOrCreate(['user_id' => $user->id]);
        
        return view('user.profile.identity', compact('user', 'identity'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'birth_certificate_number' => 'nullable|string|max:255',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'family_card_number' => 'nullable|string|max:255',
            'family_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'child_identity_card_number' => 'nullable|string|max:255',
            'child_identity' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'national_id_number' => 'nullable|string|max:255',
            'national_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bpjs_number' => 'nullable|string|max:255',
            'bpjs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'private_insurance_number' => 'nullable|string|max:255',
            'private_insurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'under_16_integrity_pact_name' => 'nullable|string|max:255',
            'under_16_integrity_pact' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $identity = IdentityDocument::firstOrCreate(['user_id' => $user->id]);

        $folder = 'identity-documents/' . $user->id;
        $data = $request->only([
            'birth_certificate_number', 'family_card_number', 'child_identity_card_number',
            'national_id_number', 'bpjs_number', 'private_insurance_number', 'under_16_integrity_pact_name'
        ]);

        // Handle File Uploads
        $fileFields = [
            'photo' => 'photo_path',
            'birth_certificate' => 'birth_certificate_path',
            'family_card' => 'family_card_path',
            'child_identity' => 'child_identity_path',
            'national_id' => 'national_id_path',
            'bpjs' => 'bpjs_path',
            'private_insurance' => 'private_insurance_path',
            'under_16_integrity_pact' => 'under_16_integrity_pact_path',
        ];

        foreach ($fileFields as $input => $dbColumn) {
            if ($request->hasFile($input)) {
                // Delete old file if exists
                if ($identity->$dbColumn && Storage::disk('public')->exists($identity->$dbColumn)) {
                    Storage::disk('public')->delete($identity->$dbColumn);
                }
                
                // Store new file
                $data[$dbColumn] = $request->file($input)->store($folder, 'public');
                
                // Temporarily assign so the trait can pick up the model's state if needed
                $identity->$dbColumn = $data[$dbColumn];
                
                // Record verification status
                $identity->recordDocumentUpload($dbColumn);
            }
        }

        $identity->update($data);

        return back()->with('success', 'Dokumen Identitas berhasil diperbarui.');
    }
}
