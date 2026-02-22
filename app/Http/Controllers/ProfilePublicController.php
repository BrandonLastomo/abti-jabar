<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProfilePublicController extends Controller
{
    public function index()
    {
        $indoorPrograms = ProgramKerja::where('category', 'indoor')
            ->latest()
            ->get();

        $beachPrograms = ProgramKerja::where('category', 'beach')
            ->latest()
            ->get();

        $cities = Club::select('city')
        ->distinct()
        ->orderBy('city')
        ->pluck('city');

        $query = Club::query();

        if(request('city')){
            $query->where('city', request('city'));
        }
        $clubs = $query->paginate(12)->withQueryString();
            
        return view('profile', compact(
            'indoorPrograms',
            'beachPrograms',
            'clubs',
            'cities'
        ));
    }
}
