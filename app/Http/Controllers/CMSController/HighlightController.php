<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::latest()->paginate(10);
        return view('cms.highlight.index', [
            'highlights' => $highlights,
            'page' => 'highlights'
        ]);
    }

    public function create()
    {
        return view('cms.highlight.create-highlight');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:indoor,beach,wheelchair',
            'link' => 'required|url'
        ]);

        Highlight::create($request->all());

        return redirect()
            ->route('highlights.index')
            ->with('success', 'Extended Highlight berhasil ditambahkan.');
    }

    public function show(Highlight $highlight)
    {
        return view('cms.highlight.show-highlight', [
            'highlight' => $highlight,
            'page' => 'highlights'
        ]);
    }

    public function edit(Highlight $highlight)
    {
        return view('cms.highlight.edit-highlight', [
            'highlight' => $highlight,
            'page' => 'highlights'
        ]);
    }

    public function update(Request $request, Highlight $highlight)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:indoor,beach,wheelchair',
            'link' => 'required|url'
        ]);

        $highlight->update($request->all());

        return redirect()
            ->route('highlights.index')
            ->with('success', 'Extended Highlight berhasil diperbarui.');
    }

    public function destroy(Highlight $highlight)
    {
        $highlight->delete();

        return back()->with('success', 'Extended Highlight berhasil dihapus.');
    }
}