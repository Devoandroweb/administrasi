<?php

namespace App\Http\Controllers;

use App\Models\MAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CAjaran extends Controller
{
    public function index()
    {
        return view('pages.ajaran.index')
        ->with('title', 'Ajaran');
    }

    public function store(Request $request)
    {
        try {
            // dd($request->validated());

            MAjaran::create($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Menambahkan Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // dd(MAjaran::find($id));
        try {
            $jurusan = MAjaran::find(decrypt($id));
            $jurusan->key = encrypt($jurusan->id_jurusan);
            return response()->json(['status' => true, 'data' => $jurusan->makeHidden('id_jurusan')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // dd(MAjaran::find($id));
        try {
            $jurusan = MAjaran::find(decrypt($id));
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
            MAjaran::find(decrypt($id))->update($request->except('_method', '_token'));
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            MAjaran::find(decrypt($id))->delete();
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    function actifed_ajaran($id)
    {
        try {
            MAjaran::query()->update(['status'=>0]);
            $ajaran = MAjaran::find(decrypt($id));
            $ajaran->status = 1;
            $ajaran->update();

            $_SESI_AJARAN = [];
            if ($ajaran != null) {
                $_SESI_AJARAN['tahun_awal'] = $ajaran->tahun_awal;
                $_SESI_AJARAN['tahun_akhir'] = $ajaran->tahun_akhir;
            }
            Session::put($_SESI_AJARAN);
            return response()->json(['status' => true, 'msg' => 'Tahun Ajaran berhasil di ubah '], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
