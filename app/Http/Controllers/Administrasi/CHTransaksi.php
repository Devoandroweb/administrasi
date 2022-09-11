<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MTunggakan;
use Illuminate\Http\Request;

class CHTransaksi extends Controller
{
    function index()
    {
        return view('pages.htransaksi.index')->with('title', 'Riwayat Transaksi');
    }
    function cetak_struk($id)
    {
        // dd(decrypt($id));
        $idDec = explode(",",decrypt($id));
        $id_transaksi = (int)$idDec[0];
        $id_siswa = (int)$idDec[1];
        // dd($idDec);
        // hitung yang sudah di bayar
        $totalDibayar = HTransaksi::where("id_siswa",$id_siswa)->sum('total');
        // hitung kurang
        $totalAdm = Siswa::where('id_siswa', $id_siswa)->sum("nominal");
        $totalTunggakan = MTunggakan::where("id_siswa",$id_siswa)->sum("nominal");
        //gabungan
        $kurang = $totalAdm + $totalTunggakan;

        $tanggungan = $totalDibayar + $kurang;

        return view('pages.pembayaran.cetak_struk',compact('id_transaksi','id_siswa','tanggungan','totalDibayar','kurang'));
    }
}
