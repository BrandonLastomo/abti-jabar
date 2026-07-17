<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\GeneralProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGeneralProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = GeneralProfile::firstOrCreate(['user_id' => $user->id]);
        
        return view('user.profile.general', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'gender' => 'nullable|in:laki-laki,perempuan',
            'birth_regency' => 'nullable|string|max:255',
            'birth_province' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'address_by_id' => 'nullable|string|max:1000',
            'current_address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'branch_board_regency' => 'nullable|string|max:255',
            'branch_board_province' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $profile = GeneralProfile::firstOrCreate(['user_id' => $user->id]);

        $profile->update($request->only([
            'gender', 'birth_regency', 'birth_province', 'birth_date', 'address_by_id', 'current_address', 'phone', 'branch_board_regency', 'branch_board_province'
        ]));

        return back()->with('success', 'Profil Umum berhasil diperbarui.');
    }
}
