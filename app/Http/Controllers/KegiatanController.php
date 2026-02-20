<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->paginate(10);

    return view('kegiatan.kegiatan', [
        'kegiatan' => $kegiatan,
        'page' => 'kegiatan'
    ]);
    }

    public function create()
    {
        return view('kegiatan.add-kegiatan', [
        'page' => 'kegiatan'
    ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'date'  => 'required|date',
            'desc'  => 'required|string',
            'link'  => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Generate slug unik
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $i = 1;

        while (Kegiatan::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('kegiatan', $filename, 'public');
        }

       Kegiatan::create([
        'name'  => $validated['name'],
        'date'  => $validated['date'],
        'desc'  => $validated['desc'],
        'slug'  => $slug,
        'image' => $imagePath,
        'link'  => $validated['link'], // TAMBAHKAN INI
    ]);

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    // =========================
    // SLUG BASED ROUTING
    // =========================

    public function show($slug)
{
    $kegiatan = Kegiatan::where('slug', $slug)->firstOrFail();

    return view('kegiatan.view-kegiatan', [
        'kegiatan' => $kegiatan,
        'page' => 'kegiatan'
    ]);
}

    public function edit(Kegiatan $kegiatan)
    {
       return view('kegiatan.edit-kegiatan', [
        'kegiatan' => $kegiatan,
        'page' => 'kegiatan'
    ]);
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'date'  => 'required|date',
            'desc'  => 'required|string',
            'link'  => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Update slug jika name berubah
        if ($validated['name'] !== $kegiatan->name) {

            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $i = 1;

            while (
                Kegiatan::where('slug', $slug)
                    ->where('id', '!=', $kegiatan->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $i++;
            }

            $validated['slug'] = $slug;
        }

        // Jika upload gambar baru
        if ($request->hasFile('image')) {

            if ($kegiatan->image && Storage::disk('public')->exists($kegiatan->image)) {
                Storage::disk('public')->delete($kegiatan->image);
            }

            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('kegiatan', $filename, 'public');
        }

        $kegiatan->update($validated);

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->image && Storage::disk('public')->exists($kegiatan->image)) {
            Storage::disk('public')->delete($kegiatan->image);
        }

        $kegiatan->delete();

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
