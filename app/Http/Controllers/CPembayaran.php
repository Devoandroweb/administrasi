<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use Illuminate\Http\Request;

class CPembayaran extends Controller
{
    function index()
    {
        return view('pages.pembayaran.index')->with('title','Pembayaran Siswa');
    }
    function searchSiswa(Request $request)
    {
        $data = [];
        // dd($request->has('q'));
        if ($request->has('q')) {

            $search = $request->q;
            $data = MSiswa::select("nis", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->orWhere('nis', 'LIKE', "%$search%")
            ->get();
            // dd($data);
        }

        return response()->json($data);
    }
    function getBiayaSiswa($id_siswa)
    {
        try {
            $siswaId = decrypt($id_siswa);
            $tggNow = Siswa::join('m_jenis_administrasi','m_jenis_administrasi.id','=','administrasi.id_jenis_administrasi')
            ->where('id_siswa',$siswaId)->get();
            $tggBefore = MTunggakan::where('id_siswa',$siswaId)->get();
            return response()->json(['tgg_now'=>$tggNow, 'tgg_before'=>$tggBefore]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    function save($id,Request $request)
    {
        // dd($request->all());
        try {
            $id_siswa = decrypt($id);
            $i = 0;
            $j = 0;
            $detailBiaya = [];
            $detailTunggakan = [];
            foreach($request->id_jenis_administrasi as $key){
                if($request->nominal[$i] != 0){
                    $detailBiaya[] = [
                        'nama_biaya' => $request->nama_biaya[$i],
                        'nominal' => (int)str_replace(".", "", $request->nominal[$i])
                    ];
                }
                $nominal = (int)str_replace(".","",$request->biaya[$i]) - (int)str_replace(".","",$request->nominal[$i]);
                Siswa::where('id_jenis_administrasi',$key)->where('id_siswa',$id_siswa)->update(['nominal'=> $nominal]);
                $i++;
            }
            foreach($request->nama_biaya_tunggakan as $key){
                if ($request->nominal_tunggakan[$j] != 0) {
                    $detailTunggakan[] = [
                        'nama_biaya' => $request->nama_biaya_tunggakan[$j],
                        'nominal' => (int)str_replace(".", "", $request->nominal_tunggakan[$j])
                    ];
                }
                $nominal = (int)str_replace(".","",$request->biaya_tunggakan[$j]) - (int)str_replace(".","",$request->nominal_tunggakan[$j]);
                MTunggakan::where('nama_tunggakan',$key)->where('id_siswa',$id_siswa)->where('ajaran',$request->tahun_ajaran[$j])->update(['nominal'=> $nominal]);
                $j++;
            }
            HTransaksi::create([
                'kode' => 0,
                'id_siswa' => $id_siswa,
                'biaya' => json_encode($detailBiaya),
                'tunggakan' => json_encode($detailTunggakan),
            ]);
            return response()->json(['status' => true, 'msg' => "Sukses Membayar"], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
        // dd("done");
    }
}
