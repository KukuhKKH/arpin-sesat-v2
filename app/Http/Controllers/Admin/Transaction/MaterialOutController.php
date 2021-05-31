<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Material;
use App\Models\Transaction\MaterialOut;
use Illuminate\Http\Request;

class MaterialOutController extends Controller
{
    public function index(Request $request, $type) {
        $data = $request->all();
        $material = Material::where('type', $type)->get();
        $query = MaterialOut::query();
        $query->where('type', $type);
        $material_out = $query->paginate(10);
        if($type == 1) {
            $title = [
                'page_name' => "Halaman Permintaan Bahan Baku",
                'page_description' => 'Manage Permintaan Bahan Baku'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Permintaan Bahan Penolong",
                'page_description' => 'Manage Permintaan Bahan Penolong'
            ];
        }
        if($request->ajax()) {
            return view("pages.admin.transaction.material_out.pagination",compact('data', 'material_out'))->render();
        }
        return view('pages.admin.transaction.material_out.index', compact('data', 'material', 'title', 'material_out'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'date' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'material_id' => 'required|numeric',
        ]);
        $material = Material::find($request->material_id);
        if($material->total < $request->amount) {
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => "Gagal",
                    'body' => "Stok Bahan Kurang Ghan"
                ]
            ], 500);
        }
        $request->merge([
            'status' => 1
        ]);
        MaterialOut::create($request->all());
        if($request->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        return response()->json([
            'status' => true,
            'message' => [
                'head' => "Berhasil",
                'body' => "Berhasil meminta ".$type
            ]
        ], 200);
    }

    public function update(Request $request, $id) {
        $material_out = MaterialOut::find($id);
        $material = Material::find($material_out->material_id);
        $total = $material_out->total;
        if($request->type == 2) {
            if($material->total < $material_out->amount) {
                return response()->json([
                    'status' => true,
                    'message' => [
                        'head' => 'Gagal',
                        'body' => 'Stok kurang'
                    ]
                ], 500);
            }
            $total = $material->total - $material_out->amount;
            $material->update([
                'total' => $total
            ]);
        }
        $material_out->update([
            'status' => $request->type
        ]);
        if($request->type == 2) {
            $type = 'Menerima';
        } else {
            $type = 'Menolak';
        }
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => $type.' Permintaan'
            ]
        ], 200);
    }
}
