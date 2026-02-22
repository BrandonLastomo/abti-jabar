<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
   public function index()
{
    $hero = Hero::first();
    return view('cms/hero', [
        'hero' => $hero,
        'page' => 'hero'
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'kicker' => 'nullable|string|max:255',
        'big'    => 'nullable|string|max:255',
        'desc'   => 'nullable|string',
        'image_desktop' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300',
        'image_mobile'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300',
    ]);

    // Ambil data pertama atau buat instance baru jika kosong
    $hero = Hero::first() ?? new Hero();

    if ($request->hasFile('image_desktop')) {
        if ($hero->image_desktop) Storage::disk('public')->delete($hero->image_desktop);
        $hero->image_desktop = $request->file('image_desktop')->store('hero', 'public');
    }

    if ($request->hasFile('image_mobile')) {
        if ($hero->image_mobile) Storage::disk('public')->delete($hero->image_mobile);
        $hero->image_mobile = $request->file('image_mobile')->store('hero', 'public');
    }

    $hero->kicker = $request->kicker;
    $hero->big    = $request->big;
    $hero->desc   = $request->desc;
    $hero->save();

    return redirect()->route('hero.index')->with('success', 'Hero Section berhasil diperbarui!');
}
}