<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\UserCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserCertificationController extends Controller
{
    public function index()
    {
        $certifications = UserCertification::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.certifications', compact('certifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'certification_name' => 'required|string|max:255',
            'certification_number' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'date_of_issue' => 'required|date',
            'type' => 'required|in:pelatih,wasit',
            'level' => 'required|in:nasional,provinsi,kab/kota,dasar',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $folder = 'certifications/' . Auth::id();
        $filePath = $request->file('file')->store($folder, 'public');

        UserCertification::create([
            'user_id' => Auth::id(),
            'certification_name' => $request->certification_name,
            'certification_number' => $request->certification_number,
            'organizer' => $request->organizer,
            'regency' => $request->regency,
            'province' => $request->province,
            'date_of_issue' => $request->date_of_issue,
            'type' => $request->type,
            'level' => $request->level,
            'file_path' => $filePath,
        ]);

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
