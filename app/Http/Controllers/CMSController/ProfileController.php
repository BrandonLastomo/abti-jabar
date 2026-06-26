<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\TeamProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = TeamProfile::latest()->paginate(10);

        return view('cms.profile.index', [
            'profiles' => $profiles,
            'page' => 'profile'
        ]);
    }

    public function create()
    {
        return view('cms.profile.add', [
            'page' => 'profile'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:indoor,beach,wheelchair',
            'subcategory' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('team_profiles', 'public');
        }

        TeamProfile::create([
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'picture' => $imagePath,
        ]);

        return redirect()
            ->route('club.index')
            ->with('success', 'Team Profile created successfully.');
    }

    public function edit(TeamProfile $club)
    {
        return view('cms.profile.edit', [
            'profile' => $club,
            'page' => 'profile'
        ]);
    }

    public function update(Request $request, TeamProfile $club)
    {
        $request->validate([
            'category' => 'required|in:indoor,beach,wheelchair',
            'subcategory' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $club->picture;

        if ($request->hasFile('picture')) {
            if ($club->picture && Storage::disk('public')->exists($club->picture)) {
                Storage::disk('public')->delete($club->picture);
            }
            $imagePath = $request->file('picture')->store('team_profiles', 'public');
        }

        $club->update([
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'picture' => $imagePath,
        ]);

        return redirect()
            ->route('club.index')
            ->with('success', 'Team Profile updated successfully.');
    }

    public function destroy(TeamProfile $club)
    {
        if ($club->picture && Storage::disk('public')->exists($club->picture)) {
            Storage::disk('public')->delete($club->picture);
        }
        $club->delete();

        return redirect()
            ->route('club.index')
            ->with('success', 'Team Profile deleted successfully.');
    }
}

