<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\OverheadCreateRequest;
use App\Http\Requests\Master\OverheadUpdateRequest;
use App\Models\Master\Overhead;
use Illuminate\Http\Request;

class OverheadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $data = $request->all();
        $query = Overhead::query();
        $query->where('type', $type);
        $overhead = $query->paginate(10);
        if($type == 1) {
            $title = [
                'page_name' => "Halaman Data Overhead Tetap",
                'page_description' => 'Manage Data Overhead Tetap'
            ];
        } else {
            $title = [
                'page_name' => "Halaman Data Overhead Variabel",
                'page_description' => 'Manage Data Overhead Variabel'
            ];
        }
        if($request->ajax()) {
            return view("pages.admin.master.overhead.pagination",compact('data', 'overhead'))->render();
        }
        return view('pages.admin.master.overhead.index', compact('data', 'overhead', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OverheadCreateRequest $request)
    {
        Overhead::create($request->all());
        if($request->type == 1) {
            $type = 'Overhead Tetap';
        } else {
            $type = 'Overhead Variabel';
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
            'data' => Overhead::find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OverheadUpdateRequest $request, $id)
    {
        $overhead = Overhead::find($id);
        $overhead->update($request->all());
        if($request->type == 1) {
            $type = 'Overhead Tetap';
        } else {
            $type = 'Overhead Variabel';
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
        $overhead = Overhead::find($id);
        if($overhead->type == 1) {
            $type = 'Bahan Baku';
        } else {
            $type = 'Bahan Penolong';
        }
        $overhead->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus '. $type
            ]
        ], 200);
    }
}
