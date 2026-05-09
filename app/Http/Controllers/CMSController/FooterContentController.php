<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\FooterContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterContentController extends Controller
{
    /**
     * Display the footer content management page.
     */
    public function index()
    {
        $footerItems = FooterContent::orderBy('sort_order')->get();
        return view('cms.footer.footer', [
            'page' => 'footer',
            'footerItems' => $footerItems,
        ]);
    }

    /**
     * Update all footer content fields at once.
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:500',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoItem = FooterContent::where('key', 'logo')->first();
            
            // Delete old logo from storage if it was uploaded (not a default asset)
            if ($logoItem && $logoItem->value && str_starts_with($logoItem->value, 'footer/')) {
                Storage::disk('public')->delete($logoItem->value);
            }

            $logoPath = $request->file('logo')->store('footer', 'public');
            FooterContent::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $logoPath]
            );
        }

        // Handle text fields
        $textFields = [
            'org_name', 'org_description',
            'nav_col_1_title', 'nav_col_2_title',
            'contact_title', 'contact_email', 'contact_phone', 'contact_address',
            'copyright',
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                FooterContent::where('key', $field)->update([
                    'value' => $request->input($field),
                ]);
            }
        }

        // Handle navigation links (JSON)
        foreach (['nav_col_1_links', 'nav_col_2_links'] as $navKey) {
            if ($request->has($navKey)) {
                $links = $request->input($navKey);
                // Filter out empty entries
                $filtered = array_values(array_filter($links, function ($link) {
                    return !empty($link['text']);
                }));

                FooterContent::where('key', $navKey)->update([
                    'value' => json_encode($filtered),
                ]);
            }
        }

        return redirect()->route('footer.index')->with('success', 'Footer berhasil diperbarui!');
    }
}
