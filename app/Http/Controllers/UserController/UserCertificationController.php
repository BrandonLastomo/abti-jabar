<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\UserCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

class UserCertificationController extends Controller
{
    public function index()
    {
        $certifications = UserCertification::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.certifications', compact('certifications'));
    }

    public function store(Request $request)
    {
        $category = $request->input('category', 'Handball');
        $validRoles = ($category === 'Handball')
            ? config('dropdown.certification_handball_roles')
            : config('dropdown.certification_non_handball_roles');
        $validCourses = ($category === 'Handball')
            ? config('dropdown.certification_handball_courses')
            : config('dropdown.certification_non_handball_courses');

        $request->validate([
            'category' => ['required', Rule::in(config('dropdown.certification_categories'))],
            'certification_name' => 'required|string|max:255',
            'certification_number' => 'required|string|max:255',
            'role' => ['required', Rule::in($validRoles)],
            'course' => ['required', Rule::in($validCourses)],
            'level' => ['required', Rule::in(config('dropdown.certification_levels'))],
            'number' => ['required', Rule::in(config('dropdown.certification_numbers'))],
            'organizer' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'date_of_issue' => 'required|date',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $folder = 'certifications/' . Auth::id();
        $filePath = $request->file('file')->store($folder, 'public');

        $cert = UserCertification::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'certification_name' => $request->certification_name,
            'certification_number' => $request->certification_number,
            'role' => $request->role,
            'course' => $request->course,
            'level' => $request->level,
            'number' => $request->number,
            'organizer' => $request->organizer,
            'regency' => $request->regency,
            'province' => $request->province,
            'date_of_issue' => $request->date_of_issue,
            'file_path' => $filePath,
        ]);
        
        $cert->recordDocumentUpload('file_path');

        return back()->with('success', 'Sertifikasi berhasil ditambahkan.');
    }

    public function destroy(UserCertification $certification)
    {
        if ($certification->user_id !== Auth::id()) {
            abort(403);
        }

        if ($certification->file_path) {
            Storage::disk('public')->delete($certification->file_path);
        }

        $certification->delete();
        return back()->with('success', 'Sertifikasi berhasil dihapus.');
    }
}
