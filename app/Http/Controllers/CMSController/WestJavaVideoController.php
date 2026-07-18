<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\WestJavaVideos;
use Illuminate\Http\Request;

class WestJavaVideoController extends Controller
{
    public function index()
    {
        $videos = WestJavaVideos::latest()->paginate(10);
        return view('cms.west-java-videos.index', [
            'videos' => $videos,
            'page' => 'west-java-videos'
        ]);
    }

    public function create()
    {
        return view('cms.west-java-videos.add-videos', [
            'page' => 'west-java-videos'
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_type' => 'nullable|string|max:255',
            'type' => 'required|in:shorts,podcast,highlights',
            'link' => 'required|url',
        ]);

        WestJavaVideos::create($request->all());

        return redirect()->route('west-java-videos.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function show(WestJavaVideos $westJavaVideo)
    {
        return view('cms.west-java-videos.show-videos', [
            'westJavaVideo' => $westJavaVideo,
            'page' => 'west-java-videos'
        ]);
    }

    public function edit(WestJavaVideos $westJavaVideo)
    {
        return view('cms.west-java-videos.edit-videos', [
            'westJavaVideo' => $westJavaVideo,
            'page' => 'west-java-videos'
        ]);
    }

    public function update(Request $request, WestJavaVideos $westJavaVideo)
    {
        $request->validate([
            'court_type' => 'nullable|string|max:255',
            'type' => 'required|in:shorts,podcast,highlights',
            'link' => 'required|url',
        ]);

        $westJavaVideo->update($request->all());

        return redirect()->route('west-java-videos.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(WestJavaVideos $westJavaVideo)
    {
        $westJavaVideo->delete();

        return back()->with('success', 'Video berhasil dihapus.');
    }
}
