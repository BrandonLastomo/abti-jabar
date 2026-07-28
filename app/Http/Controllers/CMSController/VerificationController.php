<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\DocumentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Display a listing of pending verifications.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'pending');

        // Get all verifications with optional filter
        $query = DocumentVerification::with(['user', 'documentable']);
        
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        $verifications = $query->orderBy('created_at', 'asc')->paginate(20);

        return view('cms.verifications.index', compact('verifications', 'filter'));
    }

    /**
     * Process a verification (Approve or Reject).
     */
    public function process(Request $request, DocumentVerification $verification)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes' => 'nullable|required_if:status,rejected|string',
        ]);

        $verification->update([
            'status' => $request->status,
            'notes' => $request->status === 'rejected' ? $request->notes : null,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen berhasil diverifikasi.');
    }
}
