<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\MPendanaan;
use App\Models\MSiswa;
use App\Models\MWhatsapp;
use App\Models\RHUser;
use Illuminate\Http\Request;
    
use Illuminate\Support\Facades\Session;

class CDashboard extends Controller
{
    public function index()
    {

        $rHuser = RHUser::with('user')->orderBy('date_login','desc')->get();
        // dd($rHuser);
        // dd(Session::get('tahun_awal'));
        $totalSiswa = MSiswa::get()->count();
        $totalPemasukan = MPendanaan::where('tipe',1)->sum('total');
        $totalPengeluaran = MPendanaan::where('tipe',2)->sum('total');
        $totalWhatsapp = MWhatsapp::get()->count();
        $dataStatistikPemasukan = [];
        $dataStatistikPengeluaran = [];
        for ($i=1; $i <= 12 ; $i++) { 
            # code...
            $dataPemasukan = MPendanaan::where('tipe', 1)->whereMonth('created_at',$i);
            $dataStatistikPemasukan[] = $dataPemasukan->sum('total'); 
        }
        for ($j=1; $j <= 12 ; $j++) { 
            # code...
            $dataPengeluaran = MPendanaan::where('tipe', 2)->whereMonth('created_at',$j);
            $dataStatistikPengeluaran[] = $dataPengeluaran->sum('total'); 
        }
        
        return view('pages.dashboard.index',compact('totalSiswa','totalPemasukan','totalPengeluaran','totalWhatsapp','dataStatistikPemasukan', 'dataStatistikPengeluaran', 'rHuser'))->with('title','Dashboard');
    }
}
