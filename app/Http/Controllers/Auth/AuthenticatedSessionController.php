<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Clear any intended URL that points to verification pages to prevent loops
        $intended = session()->get('url.intended');
        if ($intended && str_contains($intended, 'verify-email')) {
            session()->forget('url.intended');
        }

        // Role-based dashboard route
        $targetRoute = $user->hasRole('superadmin') 
            ? 'cms.dashboard' 
            : ($user->hasRole('admin') ? 'admin.dashboard' : 'user.profile');

        return redirect()->intended(route($targetRoute));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
