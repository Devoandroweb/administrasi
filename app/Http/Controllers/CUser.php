<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class CUser extends Controller
{
    public function index()
    {
        
        return view('pages.user.index')
        ->with('title', 'User Management');
    }
    
    public function store(Request $request)
    {
        try {
            
            $mUser = new User;
            $this->credentials($mUser, $request);
            $mUser->save();
            return response()->json(['status'=>true,'msg' => 'Sukses Menambahkan Data'],200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
        

    }

    public function show($id)
    {
        // dd(User::find($id));
        try {
            $user = User::find(decrypt($id));
            $user->key = encrypt($user->id);
            return response()->json(['status' => true, 'data' => $user->makeHidden('id')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }

    }
    public function edit($id)
    {
        // dd(User::find($id));
        try {
            $user = User::find(decrypt($id));
            $user->key = encrypt($user->id);
            return response()->json(['status' => true, 'data' => $user->makeHidden('id')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }

    }
    public function update($id, Request $request)
    {
        try {
            $mUser = User::find(decrypt($id));
            $this->credentials($mUser, $request);
            $mUser->update();
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            User::updateDeleted($id);
            return response()->json(['status' => true,'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    
    function credentials($mUser,$request)
    {
        $mUser->name = $request->username;
        $mUser->email = $request->email;
        $mUser->role = $request->role;
        if($request->filled('password')){
            $mUser->password = Hash::make($request->password);
        }
    }
    
    function check_username()
    {
        $q = $_GET['q'];
        $countUser = User::where('name', $q)->get()->count();
        return response()->json(['status' => true, 'data' => $countUser]);
        
    }
}
