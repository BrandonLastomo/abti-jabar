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
        if (auth()->user()->hasRole('admin')) {
            $clubs = Club::where('admin_id', auth()->id())->latest()->get();
        } else {
            $clubs = Club::latest()->get();
        }
        $page = 'profile';
        return view('cms.club.index', compact('clubs', 'page'));
    }

    public function create()
    {
        // Admins can only create a club if they don't have one already
        if (auth()->user()->hasRole('admin') && \App\Models\Club::where('admin_id', auth()->id())->exists()) {
            return redirect()->route('admin.dashboard')->with('error', 'Setiap admin hanya dapat mengelola 1 klub.');
        }

        $page = 'profile';
        // Only admins who do not already have a club assigned
        $assignedAdminIds = \App\Models\Club::whereNotNull('admin_id')->pluck('admin_id')->toArray();
        $admins = \App\Models\User::role('admin')->whereNotIn('id', $assignedAdminIds)->get();
        return view('cms.club.add-club', compact('page', 'admins'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('admin') && \App\Models\Club::where('admin_id', auth()->id())->exists()) {
            return redirect()->route('admin.dashboard')->with('error', 'Setiap admin hanya dapat mengelola 1 klub.');
        }

        if (!empty($request->admin_id)) {
            $alreadyAssigned = \App\Models\Club::where('admin_id', $request->admin_id)->exists();
            if ($alreadyAssigned) {
                return back()->withInput()->withErrors(['admin_id' => 'Admin yang dipilih sudah mengelola klub lain. Setiap admin hanya dapat mengelola 1 klub.']);
            }
        }
        
        $data = $request->validate([
            'admin_id' => 'nullable|exists:users,id',
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

        if (auth()->user()->hasRole('admin')) {
            $data['admin_id'] = auth()->id();
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('clubs/pictures', 'public');
        }

        Club::create($data);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Your Club has been created successfully.');
        }

        return redirect()->route('club.index')->with('success', 'Club created successfully.');
    }

    public function edit(Club $club)
    {
        if (auth()->user()->hasRole('admin') && $club->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        $page = 'profile';
        // Only admins who do not already have another club assigned (plus current club's admin)
        $assignedAdminIds = \App\Models\Club::whereNotNull('admin_id')
            ->where('id', '!=', $club->id)
            ->pluck('admin_id')
            ->toArray();
        $admins = \App\Models\User::role('admin')->whereNotIn('id', $assignedAdminIds)->get();
        return view('cms.club.edit-club', compact('club', 'page', 'admins'));
    }

    public function update(Request $request, Club $club)
    {
        if (auth()->user()->hasRole('admin') && $club->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if (!empty($request->admin_id) && $request->admin_id != $club->admin_id) {
            $alreadyAssigned = \App\Models\Club::where('admin_id', $request->admin_id)
                ->where('id', '!=', $club->id)
                ->exists();
            if ($alreadyAssigned) {
                return back()->withInput()->withErrors(['admin_id' => 'Admin yang dipilih sudah mengelola klub lain. Setiap admin hanya dapat mengelola 1 klub.']);
            }
        }

        $validationRules = [
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
        ];
        
        if (auth()->user()->hasRole('superadmin')) {
            $validationRules['admin_id'] = 'nullable|exists:users,id';
        }

        $data = $request->validate($validationRules);

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

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Club updated successfully.');
        }

        return redirect()->route('club.index')->with('success', 'Club updated successfully.');
    }

    public function destroy(Club $club)
    {
        if (auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

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


