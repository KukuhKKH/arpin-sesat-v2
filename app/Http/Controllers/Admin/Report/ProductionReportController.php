<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\Coa;
use App\Models\Master\Material;
use App\Models\Master\Product;
use App\Models\Transaction\MaterialTransaction;
use App\Models\Transaction\ProductTransaction;
use Illuminate\Http\Request;

class ProductionReportController extends Controller
{
    public function index() {
        $title = [
            'page_name' => "Halaman Harga Pokok Produksi",
            'page_description' => 'Manage Harga Pokok Produksi'
        ];
        return view('pages.admin.report.production.index', compact('title'));
    }

    public function post(Request $request) {
        sleep(3);
        $RAW_MATERIAL = 1; // Code

        $total_stock_material = 0; // Persediaan bahan Baku Awal Dari COA
        $total_buying_material = 0; // Pembelian Bahan Baku
        $total_stock_material_end = 0; // Persediaan bahan Baku Akhir
        $total_overhead_fix = 0; // Overhead Tetap
        $total_overhead_var = 0; // Overhead Variabel
        $total_help_material = 0; // Bahan Penolong
        $total_salary = 0; // Biaya Tenaga Kerja
        $total_dalamproses_awal = 0; //Persediaan produk dalam proses awal
        $total_dalamproses_akhir = 0; //Persediaan produk dalam proses akhir


        $stock_material_raw = Material::where('type', $RAW_MATERIAL)->get(); // All bahan Baku
        foreach ($stock_material_raw as $key => $value) {
            $total_stock_material_end += $value->total * $value->price;
        }

        $material_transaction = MaterialTransaction::with('material')
                                            ->where('type', $RAW_MATERIAL)
                                            ->get(); // All Pembelian bahan Baku
        foreach ($material_transaction as $key => $value) {
            $total_buying_material += $value->material->price * $value->amount;
        }

        $ProductTransaction = ProductTransaction::all(); // Get Semua Produksi

        foreach ($ProductTransaction as $key => $value) {
            // Perhitungan Over Endas
            $data_overhead_fix = $value->transaction_overhead()->with('overhead')->get();
            foreach ($data_overhead_fix as $key => $v) {
                if($v->overhead->type == 1) {
                    $total_overhead_fix += $v->overhead->price;
                } else {
                    $total_overhead_var += $v->overhead->price;
                }
            }

            $data_material = $value->transaction_material()->with('material')->get();

            foreach ($data_material as $key => $v) {
                if($v->material->type == 2) {
                    $total_help_material += $v->material->price * $v->amount;
                }
            }

            $total_salary += $value->team->salary;
        }

        $total_stock_material += Coa::where('code', '1-102')->first()->balance;
        $total_dalamproses_awal += Coa::where('code', '5-104')->first()->balance;
        $total_dalamproses_akhir += Coa::where('code', '5-105')->first()->balance;

        if($request->isMethod('post')) {
            return view('pages.admin.report.production.table', compact( 'total_dalamproses_akhir','total_stock_material', 'total_buying_material', 'total_stock_material_end', 'total_overhead_fix', 'total_overhead_var', 'total_help_material', 'total_salary','total_dalamproses_awal'))->render();
        } else {
            return view('pages.admin.report.production.print', compact( 'total_dalamproses_akhir','total_stock_material', 'total_buying_material', 'total_stock_material_end', 'total_overhead_fix', 'total_overhead_var', 'total_help_material', 'total_salary','total_dalamproses_awal'));
        }
    }

    public function produk() {
        $title = [
            'page_name' => "Halaman Harga Pokok Produksi",
            'page_description' => 'Manage Harga Pokok Produksi'
        ];

        $product = Product::all();
        return view('pages.admin.report.product.index', compact('title', 'product'));
    }

    public function post_produk(Request $request) {
        $total_material = 0;
        $total_material_helper = 0;
        $total_salary = 0;
        $total_overhead_fix = 0;
        $total_overhead_var = 0;

        $product = $request->product;
        $productTransaction = ProductTransaction::with(['transaction_material', 'transaction_overhead', 'team'])->whereHas('product', function($q) use ($product) {
            $q->where("id", $product);
        })->get();

        foreach ($productTransaction as $key => $value) {
            $materials = $value->transaction_material()->with('material')->get(); // Material
            foreach ($materials as $material) {
                if($material->material->type == 1) {
                    $total_material += $material->material->price * $material->amount;
                } else {
                    $total_material_helper += $material->material->price * $material->amount;
                }
            }

            $total_salary += $value->team->salary; // Salary

            /** Overhead */
            $overheads = $value->transaction_overhead()->with('overhead')->get();
            foreach ($overheads as $overhead) {
                if($overhead->overhead->type == 1) {
                    $total_overhead_fix += $overhead->overhead->price;
                } else {
                    $total_overhead_var += $overhead->overhead->price;
                }
            }
        }


        if($request->isMethod('post')) {
            return view('pages.admin.report.product.table', [
                'total_material' => $total_material,
                'total_material_helper' => $total_material_helper,
                'total_salary' => $total_salary,
                'total_overhead_fix' => $total_overhead_fix,
                'total_overhead_var' => $total_overhead_var
            ])->render();
        } else {
            return view('pages.admin.report.product.print', [
                'total_material' => $total_material,
                'total_material_helper' => $total_material_helper,
                'total_salary' => $total_salary,
                'total_overhead_fix' => $total_overhead_fix,
                'total_overhead_var' => $total_overhead_var,
                'product' => Product::find($product)
            ]);
        }
    }
}
