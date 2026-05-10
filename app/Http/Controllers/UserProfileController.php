<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Show the user profile page with their documents.
     */
    public function index()
    {
        $user = Auth::user();
        $documents = $user->documents()->latest()->get();

        return view('user.profile', compact('user', 'documents'));
    }

    /**
     * Upload a new document.
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,webp,doc,docx|max:5120',
            'file_name' => 'required|string|max:255',
        ]);

        $file = $request->file('document');
        $path = $file->store('user-documents/' . Auth::id(), 'public');

        UserDocument::create([
            'user_id' => Auth::id(),
            'file_name' => $request->file_name,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Dokumen berhasil diupload dan menunggu verifikasi.');
    }

    /**
     * Delete a document (only if pending).
     */
    public function deleteDocument(UserDocument $document)
    {
        // Ensure user can only delete their own pending documents
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        if ($document->status !== 'pending') {
            return back()->with('error', 'Hanya dokumen berstatus pending yang dapat dihapus.');
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
