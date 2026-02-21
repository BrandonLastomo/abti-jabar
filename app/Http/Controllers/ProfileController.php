<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clubs = Club::latest()->paginate(10);

        return view('cms.club.index', [
            'clubs' => $clubs,
            'page' => 'club'
        ]);
    }

    public function create()
    {
        return view('cms.club.add-club', [
            'page' => 'club'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'director_club' => 'required|string|max:255',
            'administrator' => 'required|string|max:255',
            'technical_director' => 'required|string|max:255',
            'training_venue' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'founded_year' => 'nullable|digits:4',
            'status' => 'required|in:member,guest',
        ]);

        Club::create($request->all());

        return redirect()
            ->route('club.index')
            ->with('success', 'Club created successfully.');
    }

    public function show(Club $club)
    {
        return view('cms.club.show-club', [
            'club' => $club,
            'page' => 'club'
        ]);
    }

    public function edit(Club $club)
    {
        return view('cms.club.edit-club', [
            'club' => $club,
            'page' => 'club'
        ]);
    }

    public function update(Request $request, Club $club)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'director_club' => 'required|string|max:255',
            'administrator' => 'required|string|max:255',
            'technical_director' => 'required|string|max:255',
            'training_venue' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'founded_year' => 'nullable|digits:4',
            'status' => 'required|in:member,guest',
        ]);

        $club->update($request->all());

        return redirect()
            ->route('club.index')
            ->with('success', 'Club updated successfully.');
    }

    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()
            ->route('club.index')
            ->with('success', 'Club deleted successfully.');
    }
}
