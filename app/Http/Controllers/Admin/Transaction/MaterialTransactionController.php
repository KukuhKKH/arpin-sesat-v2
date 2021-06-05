<?php

namespace App\Http\Controllers\Admin\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Master\Supplier;
use App\Models\Transaction\MaterialTransaction;

class MaterialTransactionController extends Controller
{
    public function index(Request $request, $type) {
        $data = $request->all();
        $supplier = Supplier::all();
        $material = Material::where('type', $type)->get();
        $query = MaterialTransaction::query();
        $query->where('type', $type);
        $materialTransaction = $query->with('supplier')->paginate(10);
        if($type == 1) {
            $title = [
                'page_name' => "Halaman Transaksi Pembelian Bahan Baku",
                'page_description' => 'Manage Transaksi Bahan Baku'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Transaksi Pembelian Bahan Penolong",
                'page_description' => 'Manage Transaksi Bahan Penolong'
            ];
        }
        if($request->ajax()) {
            return view("pages.admin.transaction.material.pagination",compact('data', 'materialTransaction'))->render();
        }
        return view('pages.admin.transaction.material.index', compact('data', 'material', 'title', 'materialTransaction', 'supplier'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'material_id' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);
        $request->merge([
            'invoice' => "INV-".date('ymdHis').rand(1000,9999)
        ]);
        MaterialTransaction::create($request->all());
        $material = Material::find($request->material_id);
        $total = $material->total + $request->amount;
        $material->update([
            'total' => $total
        ]);
        if($request->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil menambah transaksi bahan '.$type
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $materialTransaction = MaterialTransaction::with('material')->find($id);
        $material = Material::find($materialTransaction->material_id);
        $total = $material->total - $materialTransaction->amount;
        $material->update([
            'total' => $total
        ]);
        if($materialTransaction->material->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        $materialTransaction->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus Transaksi '. $type
            ]
        ], 200);
    }
}
