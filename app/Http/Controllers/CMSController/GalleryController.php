<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('photos')
                        ->latest()
                        ->paginate(10);

        return view('cms.gallery.index', [
            'galleries' => $galleries,
            'page' => 'gallery'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.gallery.add-gallery', [
            'page' => 'gallery'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'photos' => 'required|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Create gallery
        $gallery = Gallery::create([
            'title' => $request->title,
            'season' => $request->season,
        ]);

        // Upload photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {

                $path = $photo->store('galleries', 'public');

                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'photo' => $path
                ]);
            }
        }

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('photos');

        return view('cms.gallery.show-gallery', [
            'gallery' => $gallery,
            'page' => 'gallery'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $gallery->load('photos');

        return view('cms.gallery.edit-gallery', [
            'gallery' => $gallery,
            'page' => 'gallery'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gallery->update([
            'title' => $request->title,
            'season' => $request->season,
        ]);

        // Upload new photos (max 10 total)
        if ($request->hasFile('photos')) {

            $currentCount = $gallery->photos()->count();
            $newPhotos = count($request->file('photos'));

            if (($currentCount + $newPhotos) > 10) {
                return back()->withErrors([
                    'photos' => 'Maximum 10 photos allowed per gallery.'
                ]);
            }

            foreach ($request->file('photos') as $photo) {

                $path = $photo->store('galleries', 'public');

                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'photo' => $path
                ]);
            }
        }

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery updated successfully.');
    }

public function deletePhoto(GalleryPhoto $photo)
{
    // Delete file from storage
    if (Storage::disk('public')->exists($photo->photo)) {
        Storage::disk('public')->delete($photo->photo);
    }

    // Delete record
    $photo->delete();

    return back()->with('success', 'Photo deleted successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete all photos from storage
        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        // Delete gallery (photos auto deleted by cascade)
        $gallery->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery deleted successfully.');
    }
}