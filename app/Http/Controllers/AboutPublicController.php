<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\History;
use App\Models\Organisasi;
use App\Models\ProgramKerja;
use App\Models\Visi;
use Illuminate\Http\Request;

class AboutPublicController extends Controller
{
    
public function index()
{
    return view('tentang-kami', [
        'history' => History::latest()->first(),
        'visi' => Visi::latest()->first(),
        'organisasi' => Organisasi::latest()->first(),
        'programKerja' => ProgramKerja::latest()->paginate(6),
        'clubs' => Club::orderBy('city')->paginate(10)
    ]);
}
}
