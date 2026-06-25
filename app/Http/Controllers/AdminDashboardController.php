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
        $tab = $request->get('tab', 'documents');

        // Documents Query
        $docQuery = UserDocument::with('user', 'verifier');
        if ($filter !== 'all') {
            $docQuery->where('status', $filter);
        }
        $documents = $docQuery->latest()->paginate(15, ['*'], 'doc_page');

        // Mutations Query
        $mutQuery = \App\Models\MutationProposal::with('user');
        if ($filter !== 'all') {
            $mutQuery->where('status', $filter);
        }
        $mutations = $mutQuery->latest()->paginate(15, ['*'], 'mut_page');

        return view('admin.dashboard', compact('documents', 'mutations', 'filter', 'tab'));
    }

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

    public function verifyMutation(Request $request, \App\Models\MutationProposal $mutation)
    {
        $mutation->update([
            'status' => 'verified',
            'admin_notes' => $request->input('notes'),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Proposal Mutasi berhasil diverifikasi.');
    }

    public function rejectMutation(Request $request, \App\Models\MutationProposal $mutation)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $mutation->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('notes'),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Proposal Mutasi ditolak.');
    }
}
