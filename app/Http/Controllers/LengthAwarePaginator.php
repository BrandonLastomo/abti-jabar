<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BigNewsController extends Controller
{
    public function index(Request $request)
    {
        $data = collect([]);

        for ($i = 1; $i <= 50; $i++) {
            $data->push([
                'id' => $i,
                'title' => "Judul Big News $i",
                'link' => "https://example.com/$i",
                'image' => $i % 2 == 0 ? 'image.jpg' : null,
            ]);
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $data
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $bignews = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view('big_news', [
            'bignews' => $bignews,
            'page' => 'big-news'
        ]);
    }
}
