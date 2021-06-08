<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\master\SellingCreateRequest;
use App\Models\Master\Customer;
use App\Models\Master\Product;
use App\Models\Transaction\ProductSelling;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();
        $query = ProductSelling::query();
        $customer = Customer::all();
        $product = Product::all();
        $selling = $query->paginate(10);
        $title = [
            'page_name' => "Halaman Penjualan",
            'page_description' => 'Manage Penjualan'
        ];
        if($request->ajax()) {
            return view("pages.admin.transaction.selling.pagination",compact('data', 'selling'))->render();
        }
        return view('pages.admin.transaction.selling.index', compact('data', 'title', 'selling', 'customer', 'product'));
    }

    public function store(SellingCreateRequest $request) {
        $master_product = Product::find($request->product_id);
        if($request->amount > $master_product->total) {
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => "Gagal",
                    'body' => "Stok produk ".$master_product->name ." adalah ".$master_product->total
                ]
            ], 500);
        }
        $last_amount = $master_product->total;
        $subtotal = $last_amount - $request->amount;
        $master_product->update([
            'total' => $subtotal
        ]);
        ProductSelling::create($request->all());
        return response()->json([
            'status' => true,
            'message' => [
                'head' => "Berhasil",
                'body' => "Berhasil menambahkan penjualan"
            ]
        ], 200);
    }

    public function destroy($id) {
        $data = ProductSelling::find($id);
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => "Berhasil",
                'body' => "Berhasil menghapus penjualan"
            ]
        ], 200);
    }
}
