<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard with pending and all documents.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'pending');

        $query = UserDocument::with('user', 'verifier');

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'verified') {
            $query->where('status', 'verified');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        }

        $documents = $query->latest()->paginate(15);

        return view('admin.dashboard', compact('documents', 'filter'));
    }

    /**
     * Verify a document.
     */
    public function verify(Request $request, UserDocument $document)
    {
        $document->update([
            'status' => 'verified',
            'notes' => $request->input('notes'),
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen berhasil diverifikasi.');
    }

    /**
     * Reject a document.
     */
    public function reject(Request $request, UserDocument $document)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $document->update([
            'status' => 'rejected',
            'notes' => $request->input('notes'),
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen ditolak.');
    }
}
