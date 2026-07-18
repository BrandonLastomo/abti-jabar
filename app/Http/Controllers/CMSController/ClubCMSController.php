<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Storage;

class ClubCMSController extends Controller
{
    public function index()
    {
        $clubs = Club::latest()->get();
        $page = 'profile';
        return view('cms.club.index', compact('clubs', 'page'));
    }

    public function create()
    {
        $page = 'profile';
        return view('cms.club.add-club', compact('page'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|in:indoor,beach,wheelchair',
            'subcategory' => 'required|in:Senior putra,Senior putri,U-21 putra,U-21 putri,U-17 putra,U-17 putri,U-15 putra,U-15 putri,Lihat Semua Tim',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|mimes:jpg,jpeg,png,webp,avif,svg|max:2048',
            'picture' => 'nullable|mimes:jpg,jpeg,png,webp,avif,svg|max:2048',
            'pengcab_address' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'office_address_complete' => 'nullable|string',
            'venue_address' => 'nullable|string|max:255',
            'venue_address_complete' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'club_status' => 'nullable|in:amatir,profesional',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('clubs/pictures', 'public');
        }

        Club::create($data);

        return redirect()->route('club.index')->with('success', 'Club created successfully.');
    }

    public function edit(Club $club)
    {
        $page = 'profile';
        return view('cms.club.edit-club', compact('club', 'page'));
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'category' => 'required|in:indoor,beach,wheelchair',
            'subcategory' => 'required|in:Senior putra,Senior putri,U-21 putra,U-21 putri,U-17 putra,U-17 putri,U-15 putra,U-15 putri,Lihat Semua Tim',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|mimes:jpg,jpeg,png,webp,avif,svg|max:2048',
            'picture' => 'nullable|mimes:jpg,jpeg,png,webp,avif,svg|max:2048',
            'pengcab_address' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'office_address_complete' => 'nullable|string',
            'venue_address' => 'nullable|string|max:255',
            'venue_address_complete' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'club_status' => 'nullable|in:amatir,profesional',
        ]);

        if ($request->hasFile('logo')) {
            if ($club->logo && Storage::disk('public')->exists($club->logo)) {
                Storage::disk('public')->delete($club->logo);
            }
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('picture')) {
            if ($club->picture && Storage::disk('public')->exists($club->picture)) {
                Storage::disk('public')->delete($club->picture);
            }
            $data['picture'] = $request->file('picture')->store('clubs/pictures', 'public');
        }

        $club->update($data);

        return redirect()->route('club.index')->with('success', 'Club updated successfully.');
    }

    public function destroy(Club $club)
    {
        if ($club->logo && Storage::disk('public')->exists($club->logo)) {
            Storage::disk('public')->delete($club->logo);
        }
        if ($club->picture && Storage::disk('public')->exists($club->picture)) {
            Storage::disk('public')->delete($club->picture);
        }

        $club->delete();

        return redirect()->route('club.index')->with('success', 'Club deleted successfully.');
    }
}


