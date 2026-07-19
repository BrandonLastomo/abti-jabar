<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MutationSetting;

class MutationSettingController extends Controller
{
    public function index()
    {
        $setting = MutationSetting::where('key', 'mutation_open')->first();
        $mutation_open = $setting ? $setting->value : '0';
        $page = 'settings';
        return view('cms.settings.index', compact('mutation_open', 'page'));
    }

    public function update(Request $request)
    {
        $value = $request->has('mutation_open') ? '1' : '0';
        MutationSetting::updateOrCreate(
            ['key' => 'mutation_open'],
            ['value' => $value]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
