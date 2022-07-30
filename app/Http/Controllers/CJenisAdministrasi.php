<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanRequest;
use App\Models\MJenisAdministrasi;

class CJenisAdministrasi extends Controller
{
    public function index()
    {
        return view('pages.jenis-administrasi.index')
        ->with('title', 'Jenis Administrasi');
    }

    public function store(JabatanRequest $request)
    {
        try {
            // dd($request->validated());
            $data = $request->all();
            $data['biaya'] = str_replace('.','',$request->biaya);
            // dd($data);
            MJenisAdministrasi::create($data);
            return response()->json(['status' => true, 'msg' => 'Sukses Menambahkan Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // dd(MJenisAdministrasi::find($id));
        try {
            $jenis_administrasi = MJenisAdministrasi::find(decrypt($id));
            $jenis_administrasi->key = encrypt($jenis_administrasi->id);
            return response()->json(['status' => true, 'data' => $jenis_administrasi->makeHidden('id')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // dd(MJenisAdministrasi::find($id));
        try {
            $jenis_administrasi = MJenisAdministrasi::find(decrypt($id));
            $jenis_administrasi->key = encrypt($jenis_administrasi->id);
            return response()->json(['status' => true, 'data' => $jenis_administrasi->makeHidden('id')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function update($id, JabatanRequest $request)
    {
        // dd(decrypt($id));
        try {
            $data = $request->safe()->except('_method', '_token');
            $data['biaya'] = str_replace('.', '', $request->biaya);
            MJenisAdministrasi::find(decrypt($id))->update($data);
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            MJenisAdministrasi::find(decrypt($id))->delete();
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
