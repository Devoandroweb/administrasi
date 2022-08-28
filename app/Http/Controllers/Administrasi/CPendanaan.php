<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\MPendanaan;
use App\Models\MSaldo;
use App\Traits\Administrasi;
use App\Traits\Saldo;
use Illuminate\Http\Request;

class CPendanaan extends Controller
{
    use Saldo;
    function pendanaan()
    {
        $title = "Pendanaan";
        $saldo = MSaldo::first()->saldo;
        return view('pages.administrasi.pendanaan.index',compact('title','saldo'));
    }
    
    function pemasukan_save(Request $request)
    {
        try {
            $data = $request->except('_method');
            $detail = [];
            // loop pertama nama kedua nominal
            $nama_pemasukan = $data['nama_pemasukan'];
            $nominal = $data['nominal'];
            $total = 0;
            for ($i = 0; $i < count($nama_pemasukan); $i++) {
                $biaya = (int)str_replace(".", "", $nominal[$i]);
                $detail[] = ["nama_biaya" => $nama_pemasukan[$i],"nominal" => $biaya];
                $total = $total + $biaya;
            }
            $pemasukan = array(
                'tipe' => 1,
                'tipe_pemasukan' => 2,
                'nama' => $request->nama,
                'detail' => json_encode($detail),
                'total' => $total,
                'saldo' => $this->updateSaldo($total),
            );
            MPendanaan::insert($pemasukan);
            $this->createPemasukan(2, $request->nama, $detail, $total);
            return response()->json(['status' => true, 'msg' => 'Sukses Menambah Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    function pengeluaran_save(Request $request)
    {
        try {
            $data = $request->except('_method');
            $detail = [];
            // loop pertama nama kedua nominal
            $nama_pengeluaran = $data['nama_pengeluaran'];
            $nominal = $data['nominal'];
            $total = 0;
            for ($i = 0; $i < count($nama_pengeluaran); $i++) {
                $biaya = (int)str_replace(".", "", $nominal[$i]);
                $detail[] = ["nama_biaya" => $nama_pengeluaran[$i],"nominal" => $biaya];
                $total = $total + $biaya;
            }
            if($this->cekSaldo($total)){
                $pengeluaran = array(
                    'tipe' => 2,
                    'nama' => $request->nama,
                    'detail' => json_encode($detail),
                    'total' => $total,
                    'saldo' => $this->updateSaldo($total,false),
                );
                MPendanaan::insert($pengeluaran);
                return response()->json(['status' => true, 'msg' => 'Sukses Menambah Data'], 200);
            }else{
                return response()->json(['status' => false, 'msg' => 'Saldo tida cukup'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
