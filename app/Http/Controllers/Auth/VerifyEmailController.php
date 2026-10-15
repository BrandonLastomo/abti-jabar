<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified and redirect to appropriate dashboard.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->route('id'));

        // Verify that the hash matches the user's email
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            abort(403, 'Tautan verifikasi tidak valid atau telah kedaluwarsa.');
        }

        // Mark email as verified if not yet verified
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // Automatically authenticate user if not logged in or logged in as a different user
        if (! Auth::check() || Auth::id() !== $user->id) {
            Auth::login($user);
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }
        }

        // Clear any intended URL that might point to verification pages to prevent redirection loops
        if ($request->hasSession()) {
            $request->session()->forget('url.intended');
        }

        $targetRoute = $user->hasRole('superadmin') 
            ? 'cms.dashboard' 
            : ($user->hasRole('admin') ? 'admin.dashboard' : 'user.profile');

        return redirect()->route($targetRoute)->with('success', 'Email berhasil diverifikasi! Selamat datang.');
    }
}
