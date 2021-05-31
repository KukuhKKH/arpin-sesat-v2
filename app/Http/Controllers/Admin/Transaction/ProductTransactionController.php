<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductTransactionController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();
        $query = MaterialOut::query();
        $material_out = $query->paginate(10);
        $title = [
            'page_name' => "Halaman Permintaan Bahan Penolong",
            'page_description' => 'Manage Permintaan Bahan Penolong'
        ];
        if($request->ajax()) {
            return view("pages.admin.transaction.material_out.pagination",compact('data', 'material_out'))->render();
        }
        return view('pages.admin.transaction.material_out.index', compact('data', 'material', 'title', 'material_out'));
    }

    public function create() {

    }

    public function store() {

    }
}
