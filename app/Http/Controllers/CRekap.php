<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use Illuminate\Http\Request;

class CRekap extends Controller
{
    function rekapPerKelas()
    {
        return view('pages.rekap.per-kelas')->with('title','Rekap per Kelas');
    }
    function rekapPerSiswa()
    {
        $q = (isset($_GET['q'])) ? $_GET['q'] : '';
        $k = (isset($_GET['k'])) ? $_GET['k'] : -1;
        // dd($q);
        $administrasi = Siswa::all();
        $terbayar = HTransaksi::all();
        $tunggakan = MTunggakan::all();
        $kelas = MKelas::all();
        $siswa = MSiswa::where(function($query) use ($q) {
                $query->where('nisn', 'LIKE', '%'.$q.'%')
                    ->orWhere('nama', 'LIKE', '%'.$q.'%');
            });
        if($k != -1){
            $siswa = $siswa->where('id_kelas',$k);
        }

        $siswa = $siswa->paginate(10);
        return view('pages.rekap.per-siswa',compact('administrasi','terbayar','siswa', 'tunggakan', 'kelas','k','q'))->with('title', 'Rekap per Siswa');
    }
}
