<?php

namespace App\Http\Controllers\Admin\Master;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\UserCreateRequest;
use App\Http\Requests\Master\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $query = User::query();
        $roles = Role::all();
        $user = $query->paginate(10);
        $title = [
            'page_name' => "Halaman Data User",
            'page_description' => 'Manage Data User'
        ];
        if($request->ajax()) {
            return view("pages.admin.master.user.pagination",compact('data', 'user'))->render();
        }
        return view('pages.admin.master.user.index', compact('data', 'user', 'title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());
        $roleName = Role::find($request->role);
        $user->assignRole($roleName->name);
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil menambahkan data user'
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
            'data' => User::with('roles')->find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if($request->password) {
            $user->update($request->all());
        } else {
            $user->update($request->except(['password']));
        }
        $roleName = Role::find($request->role);
        $user->syncRoles($roleName);
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil update user'
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
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => 'Berhasil hapus user'
            ]
        ], 200);
    }
}
