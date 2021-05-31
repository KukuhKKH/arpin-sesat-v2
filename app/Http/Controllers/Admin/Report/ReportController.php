<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\MaterialTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function material_index($type) {
        if($type == 1) {
            $title = [
                'page_name' => "Halaman Data Bahan Baku",
                'page_description' => 'Manage Data Bahan Baku'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Data Bahan Penolong",
                'page_description' => 'Manage Data Bahan Penolong'
            ];
        }
        return view('pages.admin.report.material.index', compact('title', 'type'));
    }

    public function material_print(Request $request, $type) {
        $material = MaterialTransaction::with('supplier')->whereHas('material', function($q) use($type) {
            $q->where('type', $type);
        })->whereBetween('date', [$request->date_start, $request->date_end])->orderBy('date', 'ASC')->get();
        return view('pages.admin.report.material.print', compact('material', 'type'));
    }
}
