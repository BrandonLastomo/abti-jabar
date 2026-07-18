<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::latest()->paginate(10);
        return view('cms.education.index', compact('educations'))->with('page', 'education');
    }

    public function create()
    {
        return view('cms.education.add')->with('page', 'education');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'responsibilities' => 'nullable|array',
            'responsibilities.*.title' => 'required_with:responsibilities|string|max:255',
            'responsibilities.*.description' => 'required_with:responsibilities|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('education', 'public');
        }

        // Re-index responsibilities to ensure valid array structure if some are removed
        if (isset($data['responsibilities'])) {
            $data['responsibilities'] = array_values($data['responsibilities']);
        }

        Education::create($data);

        return redirect()->route('education.index')->with('success', 'Education entry created successfully.');
    }

    public function show(Education $education)
    {
        return view('cms.education.show', compact('education'))->with('page', 'education');
    }

    public function edit(Education $education)
    {
        return view('cms.education.edit', compact('education'))->with('page', 'education');
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'responsibilities' => 'nullable|array',
            'responsibilities.*.title' => 'required_with:responsibilities|string|max:255',
            'responsibilities.*.description' => 'required_with:responsibilities|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($education->image && Storage::disk('public')->exists($education->image)) {
                Storage::disk('public')->delete($education->image);
            }
            $data['image'] = $request->file('image')->store('education', 'public');
        }

        if (isset($data['responsibilities'])) {
            $data['responsibilities'] = array_values($data['responsibilities']);
        } else {
            $data['responsibilities'] = [];
        }

        $education->update($data);

        return redirect()->route('education.index')->with('success', 'Education entry updated successfully.');
    }

    public function destroy(Education $education)
    {
        if ($education->image && Storage::disk('public')->exists($education->image)) {
            Storage::disk('public')->delete($education->image);
        }
        $education->delete();

        return redirect()->route('education.index')->with('success', 'Education entry deleted successfully.');
    }
}


