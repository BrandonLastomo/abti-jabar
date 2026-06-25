<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $mutation_open = Setting::getVal('mutation_open', '0');
        return view('cms.settings.index', [
            'mutation_open' => $mutation_open,
            'page' => 'settings'
        ]);
    }

    public function update(Request $request)
    {
        $mutation_open = $request->has('mutation_open') ? '1' : '0';
        
        Setting::updateOrCreate(
            ['key' => 'mutation_open'],
            ['value' => $mutation_open]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
