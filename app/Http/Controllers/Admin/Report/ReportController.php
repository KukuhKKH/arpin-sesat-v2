<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\MaterialTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function material_index() {
        $title = [
            'page_name' => "Halaman Laporan Pemasukan Baku Baku",
            'page_description' => 'Manage Laporan Pemasukan Baku Baku'
        ];
        return view('pages.admin.report.material.index', compact('title'));
    }

    public function material_print(Request $request) {
        $material = MaterialTransaction::with('supplier')->whereBetween('date', [$request->date_start, $request->date_end])->orderBy('date', 'ASC')->get();
        return view('pages.admin.report.material.print', compact('material'));
    }
}
