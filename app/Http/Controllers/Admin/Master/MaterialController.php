<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MaterialCreateRequest;
use App\Http\Requests\Master\MaterialUpdateRequest;
use App\Models\Master\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $data = $request->all();
        $query = Material::query();
        $query->where('type', $type);
        $material = $query->paginate(10);
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
        if($request->ajax()) {
            return view("pages.admin.master.material.pagination",compact('data', 'material'))->render();
        }
        return view('pages.admin.master.material.index', compact('data', 'material', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialCreateRequest $request)
    {
        Material::create($request->all());
        if($request->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil menambahkan '. $type
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
            'data' => Material::find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialUpdateRequest $request, $id)
    {
        $material = Material::find($id);
        $material->update($request->all());
        if($request->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil update '. $type
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
        $material = Material::find($id);
        if($material->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        $material->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus '. $type
            ]
        ], 200);
    }
}
