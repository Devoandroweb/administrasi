<?php

namespace App\Http\Controllers;

use App\Models\MKelas;
use Illuminate\Http\Request;

class CKelas extends Controller
{
    public function index()
    {
        return view('pages.kelas.index')
        ->with('title', 'Kelas');
    }

    public function store(Request $request)
    {
        try {
            // dd($request->validated());

            MKelas::create($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Menambahkan Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // dd(MKelas::find($id));
        try {
            $jurusan = MKelas::find(decrypt($id));
            $jurusan->key = encrypt($jurusan->id_jurusan);
            return response()->json(['status' => true, 'data' => $jurusan->makeHidden('id_jurusan')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // dd(MKelas::find($id));
        try {
            $kelas = MKelas::where('id_kelas',decrypt($id))->with('jurusan')->first();
            $kelas->key = encrypt($kelas->id_kelas);
            return response()->json(['status' => true, 'data' => $kelas->makeHidden('id_kelas')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function update($id, Request $request)
    {
        // dd(decrypt($id));
        try {
            MKelas::find(decrypt($id))->update($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            MKelas::find(decrypt($id))->delete();
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
