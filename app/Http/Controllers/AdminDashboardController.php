<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $myClub = \App\Models\Club::where('admin_id', Auth::id())->first();
        
        return view('admin.dashboard', compact('myClub'));
    }

    public function documents(Request $request)
    {
        $filter = $request->get('filter', 'pending');

        $docQuery = UserDocument::with('user', 'verifier');
        if ($filter !== 'all') {
            $docQuery->where('status', $filter);
        }
        $documents = $docQuery->latest()->paginate(15);

        return view('admin.documents', compact('documents', 'filter'));
    }

    public function mutations(Request $request)
    {
        $filter = $request->get('filter', 'pending');

        $mutQuery = \App\Models\MutationProposal::with('user');
        if ($filter !== 'all') {
            $mutQuery->where('status', $filter);
        }
        $mutations = $mutQuery->latest()->paginate(15);

        return view('admin.mutations', compact('mutations', 'filter'));
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
