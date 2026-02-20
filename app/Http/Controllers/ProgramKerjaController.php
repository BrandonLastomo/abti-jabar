<?php

namespace App\Http\Controllers;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programKerja = ProgramKerja::latest()->paginate(10);

        return view('program_kerja.index', [
            'programKerja' => $programKerja,
            'page' => 'program-kerja'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('program_kerja.add', [
            'page' => 'program-kerja'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'hero_meta'   => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'year'   => 'required|string|max:10',
            'doc'   => 'required|string|max:255',
            'desc'   => 'required|string|max:255',
            'thumbnail_text' => 'nullable|string|max:255',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $slug = Str::slug($request->title);

        if (ProgramKerja::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('program_kerja', 'public');
        }

        ProgramKerja::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'hero_meta'   => $request->hero_meta,
            'category'   => $request->category,
            'year'   => $request->year,
            'doc'   => $request->doc,
            'desc'   => $request->desc,
            'thumbnail_text' => $request->thumbnail_text,
            'image'   => $imagePath,
        ]);

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKerja $programKerja)
    {
        return view('program_kerja.show', [
            'programKerja' => $programKerja,
            'page' => 'show program kerja'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramKerja $programKerja)
    {
        return view('program_kerja.edit', [
            'programKerja' => $programKerja,
            'page' => 'edit program kerja'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramKerja $programKerja)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'hero_meta'   => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'year'   => 'required|string|max:10',
            'doc'   => 'required|string|max:255',
            'desc'   => 'required|string|max:255',
            'thumbnail_text' => 'nullable|string|max:255',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $slug = Str::slug($request->title);

        if (
            ProgramKerja::where('slug', $slug)
            ->where('id', '!=', $programKerja->id)
            ->exists()
        ) {
            $slug .= '-' . time();
        }

        $imagePath = null;

        if ($request->hasFile('image')) {

            if ($programKerja->image && Storage::disk('public')->exists($programKerja->image)) {
                Storage::disk('public')->delete($programKerja->image);
            }

            $imagePath = $request->file('image')
                ->store('program_kerja', 'public');
        }

        ProgramKerja::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'hero_meta'   => $request->hero_meta,
            'category'   => $request->category,
            'year'   => $request->year,
            'doc'   => $request->doc,
            'desc'   => $request->desc,
            'thumbnail_text' => $request->thumbnail_text,
            'image'   => $imagePath,
        ]);

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil ditambahkan');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKerja $programKerja)
    {
        if ($programKerja->image && Storage::disk('public')->exists($programKerja->image)) {
            Storage::disk('public')->delete($programKerja->image);
        }

        $programKerja->delete();

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil dihapus');
    }
}
