<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $user = $request->user();
            $targetRoute = $user->hasRole('superadmin') ? 'cms.dashboard' : ($user->hasRole('admin') ? 'admin.dashboard' : 'user.profile');
            return redirect()->route($targetRoute);
        }

        return view('auth.verify-email');
    }
}
