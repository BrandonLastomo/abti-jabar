<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->paginate(10);

        return view('anggota.anggota', [
            'anggota' => $anggota,
            'page' => 'anggota'
        ]);
    }

    public function create()
    {
        return view('anggota.add-anggota', [
            'page' => 'anggota'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city'      => 'required|string|max:255',
            'lead_name' => 'required|string|max:255',
            'sec_name'  => 'required|string|max:255',
            'email'     => 'nullable|email',
            'link'      => 'nullable|url',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Generate slug unik dari city
        $baseSlug = Str::slug($validated['city']);
        $slug = $baseSlug;
        $i = 1;

        while (Anggota::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        $validated['slug'] = $slug;

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('anggota', 'public');
        }

        Anggota::create($validated);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

  public function show($slug)
{
    // 1. Cari data berdasarkan slug, jika tidak ada langsung 404
    $anggota = Anggota::where('slug', $slug)->firstOrFail();

    // 2. Kembalikan ke view dengan membawa data anggota dan variabel page
    return view('anggota.view-anggota', [
        'anggota' => $anggota,
        'page'    => 'anggota'
    ]);
}
    public function edit(Anggota $anggota)
    {
        return view('anggota.edit-anggota', [
            'anggota' => $anggota,
            'page' => 'anggota'
        ]);
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'city'      => 'required|string|max:255',
            'lead_name' => 'required|string|max:255',
            'sec_name'  => 'required|string|max:255',
            'email'     => 'nullable|email',
            'link'      => 'nullable|url',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update slug kalau city berubah
        if ($validated['city'] !== $anggota->city) {

            $baseSlug = Str::slug($validated['city']);
            $slug = $baseSlug;
            $i = 1;

            while (
                Anggota::where('slug', $slug)
                    ->where('id', '!=', $anggota->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $i++;
            }

            $validated['slug'] = $slug;
        }

        // Upload logo baru
        if ($request->hasFile('logo')) {

            if ($anggota->logo && Storage::disk('public')->exists($anggota->logo)) {
                Storage::disk('public')->delete($anggota->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('anggota', 'public');
        }

        $anggota->update($validated);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->logo && Storage::disk('public')->exists($anggota->logo)) {
            Storage::disk('public')->delete($anggota->logo);
        }

        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}
