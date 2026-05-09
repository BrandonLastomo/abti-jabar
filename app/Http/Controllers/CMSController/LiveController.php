<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Live;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $live = Live::latest()->paginate(10);

        return view('cms.live.index', [
            'live' => $live,
            'page' => 'live'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.live.add', [
            'page' => 'live'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'link'   => 'required|string|max:255',
            'date'   => 'required|string|max:255',
            'time'   => 'required|string|max:255',
        ]);

        
        // Kalau is_live diceklis, matiin semua yang lagi live
        if ($request->boolean('is_live')) {
            Live::where('is_live', true)->update(['is_live' => false]);
        }
            
        Live::create([
            'title'   => $request->title,
            'link'    => $request->link,
            'date'   => $request->date,
            'time'   => $request->time,
            'is_live' => $request->boolean('is_live'),
        ]);

        return redirect()->route('cms.live.index')
            ->with('success', 'Live Content berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function extractVideoId($url)
    {
        preg_match(
            '/(youtu\.be\/|v=|\/live\/|embed\/)([a-zA-Z0-9_-]+)/',
            $url,
            $matches
        );

        return $matches[2] ?? null;
    }

    public function show(Live $live)
    {

        $videoId = $this->extractVideoId($live->link);

        return view('cms.live.show', [
            'live' => $live,
            'videoId' => $videoId,
            'page' => 'show live content'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Live $live)
    {
        return view('cms.live.edit', [
            'live' => $live,
            'page' => 'edit live content'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Live $live)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'link'   => 'required|string|max:255',
            'date'   => 'required|string|max:255',
            'time'   => 'required|string|max:255',
        ]);

        // Kalau is_live diceklis, matiin yang lain
        if ($request->boolean('is_live')) {
            Live::where('is_live', true)
                ->where('id', '!=', $live->id)
                ->update(['is_live' => false]);
        }

        $live->update([
            'title'   => $request->title,
            'link'    => $request->link,
            'date'   => $request->date,
            'time'   => $request->time,
            'is_live' => $request->boolean('is_live'),
        ]);

        return redirect()->route('cms.live.index')
            ->with('success', 'Live Content berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Live $live)
    {
        $live->delete();

        return redirect()->route('cms.live.index')
            ->with('success', 'Live Content berhasil dihapus');
    }

    public function toggleLive(Live $live)
    {
        // Kalau mau diaktifkan, matikan yang lain dulu
        if (!$live->is_live) {
            Live::where('is_live', true)->update(['is_live' => false]);
        }
 
        $live->update(['is_live' => !$live->is_live]);
 
        return redirect()->route('cms.live.index')
            ->with('success', $live->is_live ? 'Livestream diaktifkan' : 'Livestream dinonaktifkan');
    }
}
