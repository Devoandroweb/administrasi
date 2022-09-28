<?php

namespace App\Http\Controllers;

use App\Models\MWhatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class CWhatsapp extends Controller
{
    public function index()
    {
        // dd();
        return view('pages.whatsapp.index')
        ->with('title', 'Whatsapp Gateway');
    }

    public function store(Request $request)
    {
        // dd(env("HOST_WAGATEWAY"));
        try {
            // dd($request->validated());
            $data = $request->except('_method', '_token', 'siswa');
            $data['tipe'] = 1;
            // dd(substr($request->no_telp, 0, 1));
            if(substr($request->no_telp, 0, 1) == "0"){
                $noTelp = substr_replace($request->no_telp,"62",0,1);
            }else{
                $noTelp = $request->no_telp;
            }
            // dd($request->no_telp);
            // dd(env("HOST_WAGATEWAY"));
            $resWa = Http::post(env("HOST_WAGATEWAY")."/send-message?number=" . str_replace(" ","", $noTelp) . "@c.us&msg=" . $request->pesan);
            if ($resWa->successful()) {
                $data['status'] = 1;
            } else {
                $data['status'] = 2;
            }
            MWhatsapp::create($data);
            return response()->json(['status' => true, 'msg' => 'Sukses Menambahkan Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // dd(MWhatsapp::find($id));
        try {
            $whatsapp = MWhatsapp::find(decrypt($id));
            $whatsapp->key = encrypt($whatsapp->id_whatsapp);
            return response()->json(['status' => true, 'data' => $whatsapp->makeHidden('id_whatsapp')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // dd(MWhatsapp::find($id));
        try {
            $whatsapp = MWhatsapp::find(decrypt($id));
            $whatsapp->key = encrypt($whatsapp->id_whatsapp);
            return response()->json(['status' => true, 'data' => $whatsapp->makeHidden('id_whatsapp')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function update($id, Request $request)
    {
        // dd(decrypt($id));
        try {
            $data = $request->except('_method', '_token', 'siswa');
            $data['tipe'] = 1;
            $data['status'] = 1;

            MWhatsapp::find(decrypt($id))->update($data);
            return response()->json(['status' => true, 'msg' => 'Sukses Mengubah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            MWhatsapp::find(decrypt($id))->delete();
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
