<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\Siswa;
use App\Models\MTunggakan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CDashboard extends Controller
{
   
    function index()
    {
        // dd(auth()->guard('siswa')->user());
        $biayaNow = Siswa::where('id_siswa',auth()->guard('siswa')->user()->id_siswa)->with('jenisAdministrasi')->get();
        $biayaBefore = MTunggakan::where('id_siswa',auth()->guard('siswa')->user()->id_siswa)->get();
        $totalTunggakan = 0;
        $totalLunas = 0;
        $totalBelumLunas = 0;
        foreach($biayaNow as $now){
            $totalTunggakan = $totalTunggakan + $now->nominal;
            if($now->nominal == 0){
                $totalLunas++;
            }else{
                $totalBelumLunas++;
            }
        }
        foreach($biayaBefore as $before){
            $totalTunggakan = $totalTunggakan + $before->nominal;
            if ($before->nominal == 0) {
                $totalLunas++;
            } else {
                $totalBelumLunas++;
            }
        }
        return view('pages.client.dashboard',compact('biayaNow', 'biayaBefore', 'totalTunggakan', 'totalLunas', 'totalBelumLunas'))->with('title','Dashboard Siswa');
    }
    function printTanggungan()
    {
        $auth = auth()->guard('siswa')->user();
        $biayaNow = Siswa::where('id_siswa', $auth->id_siswa)->with('jenisAdministrasi')->get();
        $biayaBefore = MTunggakan::where('id_siswa', $auth->id_siswa)->get();
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'calibri']);
        $pdf = Pdf::loadView('pages.client.cetak_tanggungan',compact('biayaNow','biayaBefore'));
        return $pdf->download('administrasi-'. $auth->nis.'-'.$auth->nama.'-'.date('YmdHis').'.pdf');
        // return view('pages.client.cetak_tanggungan');
    }
}
