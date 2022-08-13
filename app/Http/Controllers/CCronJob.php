<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MJenisAdministrasi;
use App\Models\MSetting;
use App\Models\MTunggakan;
use App\Models\TCicilan;
use App\Models\TSPP;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CCronJob extends Controller
{
    use Helper;
    private $bulan = null;
    function updateSpp()
    {
        try {
            //code...
            $mSetting = MSetting::where('kode','spp')->first();
            $dateSetting = date("Y-m",strtotime($mSetting->value));
            if($dateSetting < date("Y-m")){
                $this->updaterSpp();
                $mSetting->value = date("Y-m-d");
                $mSetting->update();
            }
            return response()->json(['status'=>true,'msg'=>'Update SPP Sukses dengan tanggal : '. date("Y-m-d")],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'msg' => $th->getMessage()],500);
        }
    }
    function updaterSpp(){
        $noBulan = date("m");
        $this->bulan = ucwords($this->convertBulan((int)$noBulan));
        $sppAdm = MJenisAdministrasi::find(1);
        // dd($sppAdm);
        $administrasiSppAllSiswa = Siswa::where('id_jenis_administrasi',$sppAdm->id)->get();
        foreach($administrasiSppAllSiswa as $adm){
            $adm->nominal = $adm->nominal + $sppAdm->biaya;
            $adm->update();
        }
        $this->updateTSpp($sppAdm->biaya);
        
    }
    function updateTSpp($nominal)
    {
        DB::table('t_spp')->update([$this->bulan => $nominal]);;
    }
    
}
