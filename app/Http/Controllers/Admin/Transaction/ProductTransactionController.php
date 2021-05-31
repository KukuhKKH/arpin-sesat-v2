<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Master\Overhead;
use App\Models\Master\Product;
use App\Models\Master\Team;
use App\Models\Transaction\ProductTransaction;
use Illuminate\Http\Request;

class ProductTransactionController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();
        $query = ProductTransaction::query();
        $production = $query->paginate(10);
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
        dd($request->all());
    }
}
