<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Master\Product;
use App\Models\Transaction\MaterialOut;
use App\Models\Transaction\MaterialTransaction;
use App\Models\Transaction\ProductSelling;
use App\Models\Transaction\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $material = Material::find($id);
        $in = MaterialTransaction::selectRaw("sum(price) price_in, date date_in, sum(amount) qty_in")->where('material_id', $id)->groupBy('date')->get();
        $out = MaterialOut::selectRaw("sum(price) price_out, date date_out, sum(amount) qty_out")->where('material_id', $id)->groupBy('date')->get();
        $new_collection = [];
        foreach ($in as $key => $value) {
            $new_collection[$value->date_in]['price_in'] = $value->price_in;
            $new_collection[$value->date_in]['date_in'] = $value->date_in;
            $new_collection[$value->date_in]['qty_in'] = $value->qty_in;
            $data = $this->searchForId($value->date_in, $out);
            if(isset($data)) {
                $new_collection[$value->date_in]['price_out'] = $out[$data]->price_out;
                $new_collection[$value->date_in]['date_out'] = $out[$data]->date_out;
                $new_collection[$value->date_in]['qty_out'] = $out[$data]->qty_out;
            }
        }
        $material = $new_collection;
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

    public function storage_index() {
        $title = [
            'page_name' => "Halaman Data Persediaan Produk",
            'page_description' => 'Manage Data Persediaan Produk'
        ];
        $product = Product::all();
        return view('pages.admin.report.storage.index', compact( 'title', 'product'));
    }

    public function storage_post($id) {
        $product = product::with(['product_transaction', 'product_selling'])->find($id);
        return view('pages.admin.report.storage.table', compact('product'))->render();
    }

    public function dev_babi() {
        // $material = Material::with(['transaction', 'out'])->find(4);
        // $material = DB::table("m_materials")
        //                     ->join("material_transactions", "m_materials.id", "=", "material_transactions.material_id", "LEFT")
        //                     ->join("material_out", "m_materials.id", "=", "material_out.material_id", "LEFT")
        //                     ->where("m_materials.id", 4)
        //                     // ->groupBy("material_transactions.date, material_out.date")
        //                     ->get();
        $in = MaterialTransaction::selectRaw("sum(price) price_in, date date_in, sum(amount) qty_in")->where('material_id', 4)->groupBy('date')->get();
        $out = MaterialOut::selectRaw("sum(price) price_out, date date_out, sum(amount) qty_out")->where('material_id', 4)->groupBy('date')->get();
        $new_collection = [];
        foreach ($in as $key => $value) {
            $new_collection[$value->date_in]['price_in'] = $value->price_in;
            $new_collection[$value->date_in]['date_in'] = $value->date_in;
            $new_collection[$value->date_in]['qty_in'] = $value->qty_in;
            $data = $this->searchForId($value->date_in, $out);
            if(isset($data)) {
                $new_collection[$value->date_in]['price_out'] = $out[$data]->price_out;
                $new_collection[$value->date_in]['date_out'] = $out[$data]->date_out;
                $new_collection[$value->date_in]['qty_out'] = $out[$data]->qty_out;
            }
        }
        dd($new_collection);
        dd($in, $out);
        // dd($material);
    }

    private function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['date_out'] === $id) {
                return $key;
            }
        }
        return null;
     }
}
