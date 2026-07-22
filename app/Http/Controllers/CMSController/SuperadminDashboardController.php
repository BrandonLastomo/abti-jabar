<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Club;
use App\Models\MutationProposal;
use Illuminate\Http\Request;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalClubs = Club::count();
        $pendingMutations = MutationProposal::where('status', 'pending')->count();
        $verifiedMutations = MutationProposal::where('status', 'verified')->count();
        $latestUsers = User::latest()->take(5)->get();

        return view('cms.dashboard', [
            'page' => 'dashboard',
            'totalUsers' => $totalUsers,
            'totalClubs' => $totalClubs,
            'pendingMutations' => $pendingMutations,
            'verifiedMutations' => $verifiedMutations,
            'latestUsers' => $latestUsers,
        ]);
    }
}
