<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\EducationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserEducationDocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $education = EducationDocument::firstOrCreate(['user_id' => $user->id]);
        
        return view('user.profile.education', compact('user', 'education'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'elementary_school_name' => 'nullable|string|max:255',
            'elementary_school' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'junior_high_school_name' => 'nullable|string|max:255',
            'junior_high_school' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'senior_high_school_name' => 'nullable|string|max:255',
            'senior_high_school' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bachelor_university_name' => 'nullable|string|max:255',
            'bachelor_university' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'masters_university_name' => 'nullable|string|max:255',
            'masters_university' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doctoral_university_name' => 'nullable|string|max:255',
            'doctoral_university' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $education = EducationDocument::firstOrCreate(['user_id' => $user->id]);

        $folder = 'education-documents/' . $user->id;
        $data = $request->only([
            'elementary_school_name', 'junior_high_school_name', 'senior_high_school_name',
            'bachelor_university_name', 'masters_university_name', 'doctoral_university_name'
        ]);

        $fileFields = [
            'elementary_school' => 'elementary_school_path',
            'junior_high_school' => 'junior_high_school_path',
            'senior_high_school' => 'senior_high_school_path',
            'bachelor_university' => 'bachelor_university_path',
            'masters_university' => 'masters_university_path',
            'doctoral_university' => 'doctoral_university_path',
        ];

        foreach ($fileFields as $input => $dbColumn) {
            if ($request->hasFile($input)) {
                if ($education->$dbColumn) {
                    Storage::disk('public')->delete($education->$dbColumn);
                }
                $data[$dbColumn] = $request->file($input)->store($folder, 'public');
            }
        }

        $education->update($data);

        return back()->with('success', 'Riwayat Pendidikan berhasil diperbarui.');
    }
}
