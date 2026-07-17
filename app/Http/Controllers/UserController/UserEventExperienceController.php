<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\EventExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEventExperienceController extends Controller
{
    public function index()
    {
        $experiences = EventExperience::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.event-experiences', compact('experiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'team_name' => 'required|string|max:255',
            'event_regency' => 'required|string|max:255',
            'event_province' => 'required|string|max:255',
            'event_role' => 'required|in:atlet,pelatih,wasit,tim manajemen,ofisial,delegasi',
            'court_type' => 'required|in:indoor,beach',
            'event_format' => 'required|in:kejuaraan,turnamen,liga,multi-event,festival',
            'competition_level' => 'required|in:internasional,nasional,provinsi,kab/kota,antar klub',
            'participant_scope' => 'required|in:umum,mahasiswa,pelajar',
            'age_category' => 'required|in:senior,junior,youth',
            'event_start_date' => 'required|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_start_date',
            'result' => 'required|in:juara 1,juara 2,juara 3,juara 4,harapan,peserta',
        ]);

        $data = $request->except('_token');
        $data['user_id'] = Auth::id();

        EventExperience::create($data);

        return back()->with('success', 'Pengalaman Event berhasil ditambahkan.');
    }

    public function destroy(EventExperience $event_experience)
    {
        if ($event_experience->user_id !== Auth::id()) {
            abort(403);
        }

        $event_experience->delete();
        return back()->with('success', 'Pengalaman Event berhasil dihapus.');
    }
}
