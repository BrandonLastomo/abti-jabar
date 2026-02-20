<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BigNews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BigNewsController extends Controller
{
    public function index()
    {
         $bignews = BigNews::latest()->paginate(10);

    return view('bignews.big_news', [
        'bignews' => $bignews,
        'page' => 'big-news'
    ]);
    }

    public function create()
    {
        return view('bignews.add-bignews', [
        'page' => 'big-news'
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'link'    => 'nullable|url',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $slug = Str::slug($request->title);

        if (BigNews::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('bignews', 'public');
        }

            BigNews::create([
                'title'   => $request->title,
                'slug'    => $slug,
                'image'   => $imagePath,
                'link'    => $request->link,
                'content' => $request->content,
            ]);

        return redirect()->route('big_news.index');
    }


    // ======================
    // SHOW
    // ======================
    public function show(BigNews $big_news)
    {
         return view('bignews.view-bignews', [
        'bignews' => $big_news,
        'page' => 'big-news'
    ]);
    }

    // ======================
    // EDIT
    // ======================
    public function edit(BigNews $big_news)
    {
         return view('bignews.edit-bignews', [
        'bignews' => $big_news,
        'page' => 'big-news'
    ]);
    }

    // ======================
    // UPDATE
    // ======================
    public function update(Request $request, BigNews $big_news)
    {
        $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'nullable|string',
        'link'    => 'nullable|url', // Tambahkan validasi link
        'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

        // Generate slug baru
        $slug = Str::slug($request->title);

        if (
            BigNews::where('slug', $slug)
            ->where('id', '!=', $big_news->id)
            ->exists()
        ) {
            $slug .= '-' . time();
        }

        $imagePath = $big_news->image;

        if ($request->hasFile('image')) {

            if ($big_news->image && Storage::disk('public')->exists($big_news->image)) {
                Storage::disk('public')->delete($big_news->image);
            }

            $imagePath = $request->file('image')
                ->store('bignews', 'public');
        }

        $big_news->update([
        'title'   => $request->title,
        'slug'    => $slug,
        'image'   => $imagePath,
        'link'    => $request->link,
        'content' => $request->content,
    ]);

        return redirect()->route('big_news.index');
            
    }

    // ======================
    // DELETE
    // ======================
    public function destroy(BigNews $big_news)
    {
        if ($big_news->image && Storage::disk('public')->exists($big_news->image)) {
            Storage::disk('public')->delete($big_news->image);
        }

        $big_news->delete();

        return redirect()->route('big_news.index')
            ->with('success');
    }
}
