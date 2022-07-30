<?php

namespace App\Http\Controllers;

use App\Models\MJurusan;
use Illuminate\Http\Request;

class CJurusan extends Controller
{
    public function index()
    {
        return view('pages.jurusan.index')
        ->with('title', 'Jurusan');
    }

    public function store(Request $request)
    {
        try {
            // dd($request->validated());
            
            MJurusan::create($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Menambahkan Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // dd(MJurusan::find($id));
        try {
            $jurusan = MJurusan::find(decrypt($id));
            $jurusan->key = encrypt($jurusan->id_jurusan);
            return response()->json(['status' => true, 'data' => $jurusan->makeHidden('id_jurusan')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // dd(MJurusan::find($id));
        try {
            $jurusan = MJurusan::find(decrypt($id));
            $jurusan->key = encrypt($jurusan->id_jurusan);
            return response()->json(['status' => true, 'data' => $jurusan->makeHidden('id_jurusan')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function update($id, Request $request)
    {
        // dd(decrypt($id));
        try {
            MJurusan::find(decrypt($id))->update($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            MJurusan::find(decrypt($id))->delete();
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
