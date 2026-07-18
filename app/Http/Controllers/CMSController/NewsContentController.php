<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
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

            'image_0'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_1'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_2'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_3'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($request->title);

        if (News::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $imagePaths = [];
        for ($i = 0; $i < 4; $i++) {
            if ($request->hasFile("image_$i")) {
                $imagePaths[] = $request->file("image_$i")->store('news', 'public');
            }
        }

        News::create([
            'title'       => $request->title,
            'slug'        => $slug,
            'category'    => $request->category,
            'content'     => $request->content,

            'images'      => json_encode($imagePaths),
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

            'image_0'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_1'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_2'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_3'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($request->title);

        if (
            News::where('slug', $slug)
                ->where('id', '!=', $news->id)
                ->exists()
        ) {
            $slug .= '-' . time();
        }

        $imagePaths = json_decode($news->images, true) ?? [];
        for ($i = 0; $i < 4; $i++) {
            if ($request->hasFile("image_$i") || $request->input("delete_image_$i")) {
                if (isset($imagePaths[$i])) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePaths[$i])) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePaths[$i]);
                    }
                    unset($imagePaths[$i]);
                }
            }
            if ($request->hasFile("image_$i")) {
                $imagePaths[$i] = $request->file("image_$i")->store('news', 'public');
            }
        }
        $imagePaths = array_values($imagePaths);

        $news->update([
            'title'       => $request->title,
            'slug'        => $slug,
            'category'    => $request->category,
            'content'     => $request->content,

            'images'      => json_encode($imagePaths),
        ]);

        return redirect()->route('news-content.index')
            ->with('success', 'News Content berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $imagePaths = json_decode($news->images, true) ?? [];
        if (!empty($imagePaths)) {
            foreach ($imagePaths as $oldImage) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldImage)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
                }
            }
        }
        
        $news->delete();

        return redirect()->route('news-content.index')
            ->with('success', 'News Content berhasil dihapus');
    }
}
