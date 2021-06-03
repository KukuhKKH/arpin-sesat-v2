<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Master\Overhead;
use App\Models\Master\Product;
use App\Models\Master\Team;
use App\Models\Transaction\ProductTransaction;
use App\Models\Transaction\ProductTransactionMaterial;
use App\Models\Transaction\ProductTransactionOverhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTransactionController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();
        $query = ProductTransaction::query();
        $production = $query->with(['product', 'team'])->paginate(10);
        $title = [
            'page_name' => "Halaman Produksi",
            'page_description' => 'Manage Produksi'
        ];
        if($request->ajax()) {
            return view("pages.admin.transaction.production.pagination",compact('data', 'production'))->render();
        }
        return view('pages.admin.transaction.production.index', compact('data', 'title', 'production'));
    }

    public function create() {
        $product = Product::all();
        $material_raw = Material::where('type', 1)->get();
        $material_help = Material::where('type', 2)->get();
        $overhead_fix = Overhead::where('type', 1)->get();
        $overhead_var = Overhead::where('type', 2)->get();
        $team = Team::all();
        $title = [
            'page_name' => "Halaman Tambah Produksi",
            'page_description' => 'Manage Tambah Produksi'
        ];
        return view('pages.admin.transaction.production.create', compact('title', 'product', 'material_raw', 'material_help', 'overhead_fix', 'overhead_var', 'team'));
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $productTransaction = ProductTransaction::create($request->all());
            foreach ($request->material_raw as $key => $value) {
                ProductTransactionMaterial::create([
                    'product_transactions_id' => $productTransaction->id,
                    'material_id' => $value,
                    'amount' => $request->material_raw_amount[$key]
                ]);
            }
            foreach ($request->material_help as $key => $value) {
                ProductTransactionMaterial::create([
                    'product_transactions_id' => $productTransaction->id,
                    'material_id' => $value,
                    'amount' => $request->material_help_amount[$key]
                ]);
            }

            foreach ($request->overhead_fix as $key => $value) {
                ProductTransactionOverhead::create([
                    'product_transactions_id' => $productTransaction->id,
                    'overhead_id' => $value,
                ]);
            }

            foreach ($request->overhead_var as $key => $value) {
                ProductTransactionOverhead::create([
                    'product_transactions_id' => $productTransaction->id,
                    'overhead_id' => $value,
                ]);
            }
            DB::commit();
            return redirect()->route('master.product.index')->with('success', 'Berhasil');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
