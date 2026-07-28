<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UserDatasExport;
use Maatwebsite\Excel\Facades\Excel;

class DataExportController extends Controller
{
    public function export(Request $request)
    {
        $exports = $request->input('exports', []);

        if (empty($exports)) {
            return back()->with('error', 'Silakan pilih setidaknya satu jenis data untuk diekspor.');
        }

        $fileName = 'MyDatas_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        $fileName = str_replace(' ', '_', $fileName);

        return Excel::download(new UserDatasExport(auth()->user(), $exports), $fileName);
    }
}
