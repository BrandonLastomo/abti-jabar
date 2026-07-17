<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\IntegrityDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserIntegrityDocumentController extends Controller
{
    public function index()
    {
        $documents = IntegrityDocument::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.integrity', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:anti_doping,pelecehan_seksual_dan_perundungan,pakta_integritas',
            'signed_date' => 'required|date',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $folder = 'integrity-documents/' . Auth::id();
        $filePath = $request->file('file')->store($folder, 'public');

        // Allow multiple or one of each type? The requirements did not specify it must be unique,
        // But usually it's one per type. Let's just create it.
        IntegrityDocument::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'signed_date' => $request->signed_date,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Dokumen Integritas berhasil ditambahkan.');
    }

    public function destroy(IntegrityDocument $integrity_document)
    {
        if ($integrity_document->user_id !== Auth::id()) {
            abort(403);
        }

        if ($integrity_document->file_path) {
            Storage::disk('public')->delete($integrity_document->file_path);
        }

        $integrity_document->delete();
        return back()->with('success', 'Dokumen Integritas berhasil dihapus.');
    }
}
