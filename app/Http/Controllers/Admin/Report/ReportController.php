<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Models\Master\Product;
use App\Models\Master\Material;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction\MaterialOut;
use App\Models\Transaction\ProductSelling;
use App\Models\Transaction\ProductTransaction;
use App\Models\Transaction\MaterialTransaction;

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
                'page_name' => "Halaman Laporan Stok Bahan Baku",
                'page_description' => 'Manage Laporan Stok Bahan Baku'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Laporan Stok Bahan Penolong",
                'page_description' => 'Manage Laporan Stok Bahan Penolong'
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
            $data = $this->searchForId($value->date_in, $out);

            $new_collection[strtotime($value->date_in)]['price_in'] = $value->price_in;
            $new_collection[strtotime($value->date_in)]['date_in'] = $value->date_in;
            $new_collection[strtotime($value->date_in)]['qty_in'] = $value->qty_in;

            if(isset($data)) {
                $new_collection[strtotime($value->date_in)]['price_out'] = $out[$data]->price_out;
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]->date_out;
                $new_collection[strtotime($value->date_in)]['qty_out'] = $out[$data]->qty_out;
                unset($out[$data]);
            }
        }
        if(count($out) > 0) {
            foreach ($out as $key => $value) {
                $new_collection[strtotime($value->date_out)]['price_out'] = $value->price_out;
                $new_collection[strtotime($value->date_out)]['date_out'] = $value->date_out;
                $new_collection[strtotime($value->date_out)]['qty_out'] = $value->qty_out;
            }
        }
        ksort($new_collection);
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
        // $product = product::with(['product_transaction', 'product_selling'])->find($id);
        $in = DB::table("product_transactions")->selectRaw("SUM(m_product.price) as price_in, sum(product_transactions.amount) as qty_in, product_transactions.date as date_in")
                    ->join("m_product", "product_transactions.product_id", "=", "m_product.id", "LEFT") ->where('product_id', $id)
                    ->groupBy("product_transactions.date")->get()->toArray();
        $out = DB::table("product_sellings")->selectRaw("SUM(m_product.price) as price_out, sum(product_sellings.amount) as qty_out, product_sellings.date as date_out")
                    ->join("m_product", "product_sellings.product_id", "=", "m_product.id", "LEFT") ->where('product_id', $id)
                    ->groupBy("product_sellings.date")->get()->toArray();
        $new_collection = [];
        foreach ($in as $key => $value) {
            $data = $this->searchForId($value->date_in, $out);

            $new_collection[strtotime($value->date_in)]['price_in'] = $value->price_in;
            $new_collection[strtotime($value->date_in)]['date_in'] = $value->date_in;
            $new_collection[strtotime($value->date_in)]['qty_in'] = $value->qty_in;

            if(isset($data)) {
                $new_collection[strtotime($value->date_in)]['price_out'] = $out[$data]['price_out'];
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]['date_out'];
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]['qty_out'];
                unset($out[$data]);
            }
        }
        if(count($out) > 0) {
            foreach ($out as $key => $value) {
                $new_collection[strtotime($value->date_out)]['price_out'] = $value->price_out;
                $new_collection[strtotime($value->date_out)]['date_out'] = $value->date_out;
                $new_collection[strtotime($value->date_out)]['qty_out'] = $value->qty_out;
            }
        }
        ksort($new_collection);
        $product = $new_collection;
        return view('pages.admin.report.storage.table', compact('product'))->render();
    }

    public function dev_babi2() {
        $in = DB::table("product_transactions")->selectRaw("SUM(m_product.price) as price_in, product_transactions.amount as qty_in, product_transactions.date as date_in")
                    ->join("m_product", "product_transactions.product_id", "=", "m_product.id", "LEFT")
                    ->groupBy("product_transactions.date")->get()->toArray();
        $out = DB::table("product_sellings")->selectRaw("SUM(m_product.price) as price_out, product_sellings.amount as qty_out, product_sellings.date as date_out")
                    ->join("m_product", "product_sellings.product_id", "=", "m_product.id", "LEFT")
                    ->groupBy("product_sellings.date")->get()->toArray();
        $new_collection = [];
        foreach ($in as $key => $value) {
            $data = $this->searchForId($value->date_in, $out);

            $new_collection[strtotime($value->date_in)]['price_in'] = $value->price_in;
            $new_collection[strtotime($value->date_in)]['date_in'] = $value->date_in;
            $new_collection[strtotime($value->date_in)]['qty_in'] = $value->qty_in;

            if(isset($data)) {
                $new_collection[strtotime($value->date_in)]['price_out'] = $out[$data]['price_out'];
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]['date_out'];
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]['qty_out'];
                unset($out[$data]);
            }
        }
        if(count($out) > 0) {
            foreach ($out as $key => $value) {
                $new_collection[strtotime($value->date_out)]['price_out'] = $value->price_out;
                $new_collection[strtotime($value->date_out)]['date_out'] = $value->date_out;
                $new_collection[strtotime($value->date_out)]['qty_out'] = $value->qty_out;
            }
        }
        ksort($new_collection);
        dd($new_collection);
    }

    public function dev_babi() {
        $in = MaterialTransaction::selectRaw("sum(price) price_in, date date_in, sum(amount) qty_in")->where('material_id', 1)->groupBy('date')->get();
        $out = MaterialOut::selectRaw("sum(price) price_out, date date_out, sum(amount) qty_out")->where('material_id', 1)->groupBy('date')->get();
        $new_collection = [];
        $count_in = count($in);
        foreach ($in as $key => $value) {
            $data = $this->searchForId($value->date_in, $out);

            $new_collection[strtotime($value->date_in)]['price_in'] = $value->price_in;
            $new_collection[strtotime($value->date_in)]['date_in'] = $value->date_in;
            $new_collection[strtotime($value->date_in)]['qty_in'] = $value->qty_in;

            if(isset($data)) {
                $new_collection[strtotime($value->date_in)]['price_out'] = $out[$data]->price_out;
                $new_collection[strtotime($value->date_in)]['date_out'] = $out[$data]->date_out;
                $new_collection[strtotime($value->date_in)]['qty_out'] = $out[$data]->qty_out;
                unset($out[$data]);
            }
        }
        if(count($out) > 0) {
            foreach ($out as $key => $value) {
                $new_collection[strtotime($value->date_out)]['price_out'] = $value->price_out;
                $new_collection[strtotime($value->date_out)]['date_out'] = $value->date_out;
                $new_collection[strtotime($value->date_out)]['qty_out'] = $value->qty_out;
            }
        }
        ksort($new_collection);
        dd($new_collection);
        dd($in->toArray(), $out->toArray());
        dd($new_collection);
        dd($in, $out);
        // dd($material);
    }

    private function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val->date_out === $id) {
                return $key;
            }
        }
        return null;
     }
}
