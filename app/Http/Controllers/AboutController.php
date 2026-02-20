<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Visi;
use App\Models\Organisasi;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        // Ambil data pertama dari masing-masing tabel
        $aboutData = [
            'history' => History::first(),
            'visi'    => Visi::first(),
            'organisasi' => Organisasi::first(),
        ];

        return view('about.about', [
            'page' => 'about',
            'aboutData' => $aboutData
        ]);
    }

    public function store(Request $request)
    {
        switch ($request->section) {
            case 'history':
                return $this->storeHistory($request);
            case 'visi':
                return $this->storeVisi($request);
            case 'organisasi':
                return $this->storeOrganisasi($request);
            default:
                abort(404);
        }
    }

    /* ================= HISTORY ================= */
    private function storeHistory(Request $request)
    {
        $timeline = [];
        if ($request->timeline_title) {
            foreach ($request->timeline_title as $i => $title) {
                $timeline[] = [
                    'title' => $title,
                    'subtitle' => $request->timeline_subtitle[$i] ?? null
                ];
            }
        }

        // Cari data history pertama, kalau gak ada buat instance baru
        $history = History::first() ?? new History();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($history->image) { Storage::disk('public')->delete($history->image); }
            $history->image = $request->file('image')->store('about/history', 'public');
        }

        $history->fill([
            'kicker' => $request->kicker,
            'title' => $request->title,
            'mobile_title' => $request->mobile_title,
            'mobile_desc' => $request->mobile_desc,
            'desc' => $request->desc,
            'timeline' => json_encode($timeline),
        ]);
        
        $history->save();

        return back()->with('success', 'Sejarah updated');
    }

    /* ================= VISI ================= */
    private function storeVisi(Request $request)
    {
        $visiModel = Visi::first() ?? new Visi();

        if ($request->hasFile('image')) {
            if ($visiModel->image) { Storage::disk('public')->delete($visiModel->image); }
            $visiModel->image = $request->file('image')->store('about/visi', 'public');
        }

        $visiModel->fill([
            'kicker' => $request->kicker,
            'title' => $request->title,
            'mobile_title' => $request->mobile_title,
            'mobile_desc' => $request->mobile_desc,
            'visi' => json_encode($request->visi),
            'misi' => json_encode($request->misi),
        ]);

        $visiModel->save();

        return back()->with('success', 'Visi Misi updated');
    }

    /* ================= ORGANISASI ================= */
    private function storeOrganisasi(Request $request)
    {
        $org = Organisasi::first() ?? new Organisasi();

        if ($request->hasFile('image')) {
            if ($org->image) { Storage::disk('public')->delete($org->image); }
            $org->image = $request->file('image')->store('about/organisasi', 'public');
        }

        $org->fill([
            'kicker' => $request->kicker,
            'title' => $request->title,
            'mobile_title' => $request->mobile_title,
            'mobile_desc' => $request->mobile_desc,
            'desc' => $request->desc,
            'tag' => json_encode($request->tag),
        ]);

        $org->save();

        return back()->with('success', 'Organisasi updated');
    }
}