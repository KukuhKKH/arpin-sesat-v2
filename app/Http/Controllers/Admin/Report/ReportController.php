<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Transaction\MaterialTransaction;
use App\Models\Transaction\ProductSelling;
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

    public function stock_material($type) {
        if($type == 1) {
            $title = [
                'page_name' => "Halaman Laporan Bahan Stok Baku",
                'page_description' => 'Manage Laporan Bahan Stok Baku'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Laporan Bahan Stok Penolong",
                'page_description' => 'Manage Laporan Bahan Stok Penolong'
            ];
        }
        $material = Material::where('type', $type)->get();
        return view('pages.admin.report.stock.material', compact('material', 'title'));
    }

    public function stock_material_post($id) {
        $material = Material::find($id);
        return view('pages.admin.report.stock.table', compact('material'))->render();
    }

    public function product_selling() {
        $title = [
            'page_name' => "Halaman Data Penjualan Produk",
            'page_description' => 'Manage Data Penjualan Produk'
        ];
        return view('pages.admin.report.selling.index', compact( 'title'));
    }

    public function product_selling_print(Request $request) {
        $selling = ProductSelling::with(['customer', 'product'])->whereBetween('date', [$request->date_start, $request->date_end])->orderBy('date', 'ASC')->get();
        return view('pages.admin.report.selling.print', compact('selling'));
    }
}
