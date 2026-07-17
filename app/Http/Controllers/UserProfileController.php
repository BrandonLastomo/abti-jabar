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
     * Show the mutation proposal form.
     */
    public function mutationForm()
    {
        $user = Auth::user();
        $mutation_open = \App\Models\MutationSetting::where('key', 'mutation_open')->value('value') ?? '0';
        $mutation_proposal = \App\Models\MutationProposal::where('user_id', $user->id)->latest()->first();

        $can_propose_mutation = true;
        if ($mutation_proposal && $mutation_proposal->created_at->diffInYears(now()) < 4) {
            $can_propose_mutation = false;
        }

        return view('user.mutation', compact('mutation_open', 'mutation_proposal', 'can_propose_mutation'));
    }

    public function submitMutation(Request $request)
    {
        $request->validate([
            'parental_consent' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'withdrawal_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'mutation_memo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'integrity_pact' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if (\App\Models\MutationSetting::where('key', 'mutation_open')->value('value') !== '1') {
            return back()->with('error', 'Pendaftaran mutasi sedang ditutup.');
        }

        $user = Auth::user();

        // Check 4 year rule
        $last_proposal = \App\Models\MutationProposal::where('user_id', $user->id)->latest()->first();
        if ($last_proposal && $last_proposal->created_at->diffInYears(now()) < 4) {
            return back()->with('error', 'Anda hanya dapat mengajukan mutasi setiap 4 tahun sekali.');
        }

        $folder = 'mutation-proposals/' . $user->id;

        $paths = [
            'user_id' => $user->id,
            'status' => 'pending',
            'parental_consent_path' => $request->file('parental_consent')->store($folder, 'public'),
            'withdrawal_letter_path' => $request->file('withdrawal_letter')->store($folder, 'public'),
            'mutation_memo_path' => $request->file('mutation_memo')->store($folder, 'public'),
            'integrity_pact_path' => $request->file('integrity_pact')->store($folder, 'public'),
        ];

        \App\Models\MutationProposal::create($paths);

        return back()->with('success', 'Proposal mutasi berhasil diajukan dan sedang menunggu verifikasi admin.');
    }

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

    public function deleteDocument(UserDocument $document)
    {
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
