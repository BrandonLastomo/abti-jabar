<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use App\Models\News;
use Illuminate\Http\Request;

class ProgramKerjaPublicController extends Controller
{
    public function show(ProgramKerja $programKerja)
    {
        $otherNews = News::latest()->take(3)->get();
        return view('program_kerja.show', compact('programKerja', 'otherNews'));
    }
}
