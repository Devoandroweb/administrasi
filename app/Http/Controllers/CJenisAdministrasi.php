<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisBiayaRequest;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MRekap;
use App\Traits\Administrasi;
use App\Traits\Helper;
use Illuminate\Http\Request;

class CJenisAdministrasi extends Controller
{
    use Helper;
    use Administrasi;
    public function index()
    {
        return view('pages.jenis-administrasi.index')
        ->with('title', 'Jenis Administrasi');
    }

    public function store(JenisBiayaRequest $request)
    {
        try {
            // dd($request->validated());
            $data = $request->except('_token');
            // dd($request->all());
            foreach(explode(",",$request->kelas) as $key){
                $data['nama'] = strtoupper($request->nama);
                $data['biaya'] = str_replace('.', '', $request->biaya);
                $data['id_kelas'] = $key;
                // create to 
                $mJenisAdm = MJenisAdministrasi::create($data);
                $this->createRekap($mJenisAdm);
            }
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
    public function update($id, JenisBiayaRequest $request)
    {
        // dd(decrypt($id));
        try {
            $data = $request->safe()->except('_method', '_token');
            $data['nama'] = strtoupper($request->nama);
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
    public function delete_multi(Request $request)
    {
        
        try {
            // dd($request->delete);
            $idDelete = [];
            foreach ($request->delete as $key) {
                array_push($idDelete, decrypt($key));
            }
            MJenisAdministrasi::destroy($idDelete);
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
