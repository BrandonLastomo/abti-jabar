<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryPublicController extends Controller
{
    public function index()
{
    $galleries = Gallery::with('photos')->latest()->get();
    return view('gallery', compact('galleries'));
}
}
