<?php

namespace App\Http\Controllers;

use App\Models\Archive;

class ArchivePublicController extends Controller
{
    public function index()
    {
        $archives = Archive::orderBy('category')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('category');

        return view('archives', [
            'archives' => $archives
        ]);
    }
}