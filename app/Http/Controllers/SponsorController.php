<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::latest()->paginate(10);
        return view('sponsor.sponsor', [
            'page' => 'sponsor',
            'sponsors' => $sponsors
        ]);
    }

    // --- PASTIKAN METHOD INI ADA ---
    public function create()
    {
        return view('sponsor.add-sponsor', [
            'page' => 'sponsor'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'link'  => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:300',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sponsors', 'public');
        }

        Sponsor::create([
            'name'  => $request->name,
            'link'  => $request->link,
            'image' => $imagePath,
        ]);

        return redirect()->route('sponsor.index')->with('success', 'Sponsor berhasil ditambahkan');
    }
    // ------------------------------

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->image) {
            Storage::disk('public')->delete($sponsor->image);
        }
        $sponsor->delete();
        return back()->with('success', 'Sponsor berhasil dihapus');
    }
    // Menampilkan halaman edit
public function edit(Sponsor $sponsor)
{
    return view('sponsor.edit-sponsor', [
        'page' => 'sponsor',
        'sponsor' => $sponsor
    ]);
}

// Memproses update data
public function update(Request $request, Sponsor $sponsor)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'link'  => 'nullable|url',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300', // nullable karena gambar tidak wajib ganti
    ]);

    $data = [
        'name' => $request->name,
        'link' => $request->link,
    ];

    if ($request->hasFile('image')) {
        // Hapus foto lama jika ada
        if ($sponsor->image) {
            Storage::disk('public')->delete($sponsor->image);
        }
        // Simpan foto baru
        $data['image'] = $request->file('image')->store('sponsors', 'public');
    }

    $sponsor->update($data);

    return redirect()->route('sponsor.index')->with('success', 'Sponsor berhasil diperbarui');
}
public function show(Sponsor $sponsor)
{
    return view('sponsor.view-sponsor', [
        'page' => 'sponsor',
        'sponsor' => $sponsor
    ]);
}
}