<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\master\ProductUpdateRequest;
use App\Models\Master\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $query = Product::query();
        $product = $query->paginate(10);
        $title = [
            'page_name' => "Halaman Data Produk Jadi",
            'page_description' => 'Manage Data Produk Jadi'
        ];
        if($request->ajax()) {
            return view("pages.admin.master.product.pagination",compact('data', 'product'))->render();
        }
        return view('pages.admin.master.product.index', compact('data', 'product', 'title'));
    }

    public function store(Request $request) {
        $request->merge([
            'total' => 0
        ]);
        Product::create($request->all());
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil menambahkan produk'
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            'status' => true,
            'data' => Product::find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil update produk'
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus product'
            ]
        ], 200);
    }
}
