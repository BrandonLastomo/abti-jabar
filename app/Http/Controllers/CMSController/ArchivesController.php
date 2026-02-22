<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archives = Archive::latest()->paginate(10);

        return view('cms.archive.index', [
            'archives' => $archives,
            'page' => 'archives'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.archive.add-archive', [
            'page' => 'archives'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Mutation Regulation,Club Regulation,Event Regulation,Sanction Regulation,Statues & Regulation',
            'file' => 'required|mimes:pdf',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')
                ->store('archives', 'public');
        }

        Archive::create($validated);

        return redirect()
            ->route('archive.index')
            ->with('success', 'Archive created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Archive $archive)
    {
        return view('cms.archive.show-archive', [
            'archive' => $archive,
            'page' => 'archives'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archive $archive)
    {
        return view('cms.archive.edit-archive', [
            'archive' => $archive,
            'page' => 'archives'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Archive $archive)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Mutation Regulation,Club Regulation,Event Regulation,Sanction Regulation,Statues & Regulation',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {

            // delete old file
            if ($archive->file && Storage::disk('public')->exists($archive->file)) {
                Storage::disk('public')->delete($archive->file);
            }

            $validated['file'] = $request->file('file')
                ->store('archives', 'public');
        }

        $archive->update($validated);

        return redirect()
            ->route('archive.index')
            ->with('success', 'Archive updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archive $archive)
    {
        if ($archive->file && Storage::disk('public')->exists($archive->file)) {
            Storage::disk('public')->delete($archive->file);
        }

        $archive->delete();

        return redirect()
            ->route('archive.index')
            ->with('success', 'Archive deleted successfully.');
    }
}