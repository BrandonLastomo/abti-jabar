<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->paginate(10);

        return view('cms.news_content.index', [
            'news' => $news,
            'page' => 'news-content'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.news_content.add', [
            'page' => 'news-content'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category'    => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'content'     => 'required|string|max:1000',
            'cta_text'    => 'required|string|max:255',
            'youtube_url' => 'required|url|max:255',
        ]);

        $slug = Str::slug($request->title);

        if (News::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        News::create([
            'title'       => $request->title,
            'slug'        => $slug,
            'category'    => $request->category,
            'content'     => $request->content,
            'cta_text'    => $request->cta_text,
            'youtube_url' => $request->youtube_url,
        ]);

        return redirect()->route('news-content.index')
            ->with('success', 'News Content berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('cms.news_content.show', [
            'news' => $news,
            'page' => 'news-content'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('cms.news_content.edit', [
            'news' => $news,
            'page' => 'news-content'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'category'    => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'content'     => 'required|string|max:1000',
            'cta_text'    => 'required|string|max:255',
            'youtube_url' => 'required|url|max:255',
        ]);

        $slug = Str::slug($request->title);

        if (
            News::where('slug', $slug)
                ->where('id', '!=', $news->id)
                ->exists()
        ) {
            $slug .= '-' . time();
        }

        $news->update([
            'title'       => $request->title,
            'slug'        => $slug,
            'category'    => $request->category,
            'content'     => $request->content,
            'cta_text'    => $request->cta_text,
            'youtube_url' => $request->youtube_url,
        ]);

        return redirect()->route('news-content.index')
            ->with('success', 'News Content berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news-content.index')
            ->with('success', 'News Content berhasil dihapus');
    }
}
