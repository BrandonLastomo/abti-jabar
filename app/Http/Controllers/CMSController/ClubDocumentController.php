<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubDocumentController extends Controller
{
    public function index(Club $club)
    {
        $page = 'profile';
        $document = $club->documents()->first();
        
        return view('cms.club.documents.index', compact('club', 'document', 'page'));
    }

    public function store(Request $request, Club $club)
    {
        $request->validate([
            'akta_notaris' => 'nullable|string|max:255',
            'akta_notaris_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'akta_notaris_date' => 'nullable|date',
            
            'badan_hukum' => 'nullable|string|max:255',
            'badan_hukum_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'badan_hukum_date' => 'nullable|date',
            
            'npwp' => 'nullable|string|max:255',
            'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'npwp_date' => 'nullable|date',
            
            'sk' => 'nullable|string|max:255',
            'sk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'sk_date' => 'nullable|date',
            
            'ad_art' => 'nullable|string|max:255',
            'ad_art_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'ad_art_date' => 'nullable|date',
            
            'keorganisasian' => 'nullable|string|max:255',
            'keorganisasian_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keorganisasian_date' => 'nullable|date',
            
            'keolahragaan' => 'nullable|string|max:255',
            'keolahragaan_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keolahragaan_date' => 'nullable|date',
        ]);

        $document = $club->documents()->first();
        if (!$document) {
            $document = new ClubDocument();
            $document->club_id = $club->id;
        }

        $fields = [
            'akta_notaris', 'badan_hukum', 'npwp', 'sk', 'ad_art', 'keorganisasian', 'keolahragaan'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $document->$field = $request->input($field);
            }
            if ($request->has($field . '_date')) {
                $document->{$field . '_date'} = $request->input($field . '_date');
            }
            
            if ($request->hasFile($field . '_file')) {
                if ($document->{$field . '_path'} && Storage::disk('public')->exists($document->{$field . '_path'})) {
                    Storage::disk('public')->delete($document->{$field . '_path'});
                }
                $document->{$field . '_path'} = $request->file($field . '_file')->store('club_documents', 'public');
            }
        }

        $document->save();

        return redirect()->route('club.documents.index', $club->id)->with('success', 'Club Documents updated successfully.');
    }
}
