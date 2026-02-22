<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventPublicController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view('event', compact('events'));
    }
}