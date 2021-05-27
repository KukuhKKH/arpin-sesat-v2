<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\master\CoaCreateRequest;
use App\Http\Requests\master\CoaUpdateRequest;
use App\Models\Master\Coa;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $query = Coa::query();
        $coa = $query->paginate(10);
        $title = [
            'page_name' => "Halaman Data COA",
            'page_description' => 'Manage Data COA'
        ];
        if($request->ajax()) {
            return view("pages.admin.master.coa.pagination",compact('data', 'coa'))->render();
        }
        return view('pages.admin.master.coa.index', compact('data', 'coa', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoaCreateRequest $request)
    {
        $request->merge([
            'balance' => 0,
            'active' => 1
        ]);
        Coa::create($request->all());
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil menambahkan data coa'
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
            'data' => Coa::find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoaUpdateRequest $request, $id)
    {
        $coa = Coa::find($id);
        $coa->update($request->all());
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil update coa'
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
        $coa = Coa::find($id);
        $coa->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus coa'
            ]
        ], 200);
    }
}
