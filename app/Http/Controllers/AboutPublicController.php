<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\History;
use App\Models\Organisasi;
use App\Models\ProgramKerja;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class AboutPublicController extends Controller
{
    
public function index()
{
    return view('tentang-kami', [
        'history' => History::latest()->first(),
        'visi' => VisiMisi::latest()->first(),
        'organisasi' => Organisasi::latest()->first(),
        'programKerja' => ProgramKerja::latest()->paginate(6),
        'clubs' => Anggota::orderBy('city')->get()
    ]);
}
}
