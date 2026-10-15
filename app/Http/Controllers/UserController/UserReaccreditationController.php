<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\UserReaccreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserReaccreditationController extends Controller
{
    /**
     * Display the reaccreditation page.
     */
    public function index()
    {
        $user = Auth::user();
        $isAthlete = ($user->generalProfile?->member_type === 'atlet');
        $reaccreditations = UserReaccreditation::where('user_id', $user->id)->latest()->get();
        $pendingProposal = $reaccreditations->where('status', 'pending')->first();

        return view('user.profile.reaccreditation', compact('user', 'isAthlete', 'reaccreditations', 'pendingProposal'));
    }

    /**
     * Store a newly submitted reaccreditation proposal.
     */
    public function store(Request $request)
    {
        $roles = config('dropdown.reaccreditation_roles', []);
        $licenses = config('dropdown.reaccreditation_licenses', []);
        $tracks = config('dropdown.reaccreditation_tracks', []);

        $request->validate([
            'role' => ['required', 'string', Rule::in($roles)],
            'applied_license' => ['required', 'string', Rule::in($licenses)],
            'track' => ['required', 'string', Rule::in($tracks)],
            'last_license_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'event_certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'program_project_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'special_requirements_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'recommendation_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $folder = 'reaccreditations/' . Auth::id();

        $data = [
            'user_id' => Auth::id(),
            'role' => $request->role,
            'applied_license' => $request->applied_license,
            'track' => $request->track,
            'status' => 'pending',
            'last_license_file' => $request->file('last_license_file')->store($folder, 'public'),
            'event_certificate_file' => $request->file('event_certificate_file')->store($folder, 'public'),
            'program_project_file' => $request->file('program_project_file')->store($folder, 'public'),
            'special_requirements_file' => $request->file('special_requirements_file')->store($folder, 'public'),
            'recommendation_file' => $request->file('recommendation_file')->store($folder, 'public'),
        ];

        $proposal = UserReaccreditation::create($data);

        // Record document uploads for verification tracking
        $proposal->recordDocumentUpload('last_license_file', Auth::id());
        $proposal->recordDocumentUpload('event_certificate_file', Auth::id());
        $proposal->recordDocumentUpload('program_project_file', Auth::id());
        $proposal->recordDocumentUpload('special_requirements_file', Auth::id());
        $proposal->recordDocumentUpload('recommendation_file', Auth::id());

        return redirect()->route('user.reaccreditations.index')->with('success', 'Pengajuan Reakreditasi berhasil dikirim dan sedang menunggu verifikasi.');
    }

    /**
     * Remove the specified reaccreditation submission.
     */
    public function destroy(UserReaccreditation $reaccreditation)
    {
        if ($reaccreditation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $files = [
            $reaccreditation->last_license_file,
            $reaccreditation->event_certificate_file,
            $reaccreditation->program_project_file,
            $reaccreditation->special_requirements_file,
            $reaccreditation->recommendation_file,
        ];

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $reaccreditation->delete();

        return redirect()->route('user.reaccreditations.index')->with('success', 'Pengajuan Reakreditasi berhasil dibatalkan.');
    }
}
