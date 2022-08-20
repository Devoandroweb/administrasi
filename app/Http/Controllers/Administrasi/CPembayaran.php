<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MRekap;
use App\Models\MRekapTunggakan;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use App\Models\MWhatsapp;
use App\Models\TCicilan;
use App\Models\TSPP;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CPembayaran extends Controller
{
    use Helper;
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
            $data = MSiswa::select("nisn", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->orWhere('nisn', 'LIKE', "%$search%")
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
        // try {
            $id_siswa = decrypt($id);
            $siswa = MSiswa::withDeleted()->where('id_siswa',$id_siswa)->first();
            $i = 0;
            $j = 0;
            $detailBiaya = [];
            $detailTunggakan = [];
            $total = 0;
            $ajaranNow = Session::get('tahun_awal')." - ". Session::get('tahun_akhir');

            //struk wa -------------------------------------------------------------------
            $strukWA_ajaranNow = "";
            $strukWA_noNow = 1;
            
            $strukWA_ajaranBefore = "";
            $strukWA_noBefore = 1;

            $strukWA = "";
            $strukWA = "Terima Kasih,\n";
            $strukWA .= "Pembayaran atas nama :\n*". $siswa->nama. "* \ntelah kami terima.\n\n";

            $strukWA .= "Dengan detail pembayaran sebagai berikut: \n\n";
            $strukWA .= "------------------------------------------------- \n\n";
            //----------------------------------------------------------------------------
            if(isset($request->id_jenis_administrasi)){

                foreach($request->id_jenis_administrasi as $key){
                    //uang di bayarkan : $request->nominal
                    $nominalBayar = (int)str_replace(".", "", $request->nominal[$i]);
                    $nominal = (int)str_replace(".", "", $request->biaya[$i]) - $nominalBayar;
                    if($nominalBayar != 0){

                        $total = $total + $nominalBayar;

                        //to save adminitrasi
                        $administrasi = Siswa::where('id_jenis_administrasi', $key)->where('id_siswa', $id_siswa)->first();
                        

                        //save to cicilan
                        $tCicilan = TCicilan::where('id_administrasi', $administrasi->id_administrasi)->first();
                        $cicilanTahapAdm = 0;
                        if ($tCicilan != null) {
                            $jsonDesk = json_decode($tCicilan->deskripsi);
                            if ($jsonDesk == null) {
                                $cicilanTahapAdm = 1;
                                $tCicilan->deskripsi = json_encode([$nominalBayar]);
                            } else {
                                $cicilanTahapAdm = count($jsonDesk) + 1;
                                array_push($jsonDesk, $nominalBayar);
                                $tCicilan->deskripsi = json_encode($jsonDesk);
                            }
                            $tCicilan->update();
                        }
                        //to save t_spp
                        //exec SPP
                        if ($key == 1) {
                            //bulan_spp
                            $tSpp = TSPP::where('id_siswa', $id_siswa)->first();
                            $bulanSpp = $request->bulan_spp;
                            $tSpp->{$bulanSpp} = $nominal;
                            $tSpp->update();
                            
                            $detailBiaya[] = [
                                'nama_biaya' => $request->nama_biaya[$i]." untuk bulan ".ucwords($bulanSpp),
                                'id_jenis_administrasi' => $key,
                                'nominal' => $nominalBayar,
                                'ajaran' => $ajaranNow,
                                'bulan_spp' => $bulanSpp
                            ];
                        }else{
                            $detailBiaya[] = [
                                'nama_biaya' => $request->nama_biaya[$i] . " tahap ke " . $cicilanTahapAdm,
                                'id_jenis_administrasi' => $key,
                                'nominal' => $nominalBayar,
                                'ajaran' => $ajaranNow
                            ];
                        }
                        //update administrasi
                        $administrasi->nominal = $tSpp->totalSpp();
                        $administrasi->update();
                        //update rekap
                        $this->saveRekap($key,$siswa->id_kelas,$nominalBayar);
                        
                        if($ajaranNow != $strukWA_ajaranNow){
                            $strukWA .= "*Tanggungan pada TA ". $ajaranNow."* \n";
                            $strukWA_ajaranNow = $ajaranNow;
                        }
                        $strukWA .= $strukWA_noNow.". ". $request->nama_biaya[$i]." Rp. ". $request->nominal[$i]." ".$this->cekExitsBulanSpp($request->bulan_spp, $request->id_jenis_administrasi) ." tahan ke " . $cicilanTahapAdm." \n";
                        $strukWA_noNow++;
                    }
                    
                    
                    $i++;
                }
            }
            if(isset($request->nama_biaya_tunggakan)){
                
                foreach($request->nama_biaya_tunggakan as $key){
                    
                    $nominalTunggakanBayar = (int)str_replace(".","",$request->nominal_tunggakan[$j]);
                    if ($nominalTunggakanBayar != 0) {
                        $total = $total + $nominalTunggakanBayar;
                        $ajaranLalu = $request->tahun_ajaran[$j];

                        $nominal = (int)str_replace(".", "", $request->biaya_tunggakan[$j]) - $nominalTunggakanBayar;
                        $mTunggakan = MTunggakan::where('nama_tunggakan', $key)->where('id_siswa', $id_siswa)->where('ajaran', $request->tahun_ajaran[$j])->first();
                        $mTunggakan->nominal = $nominal;
                        $mTunggakan->update();

                        //cicilam
                        $tCicilan = TCicilan::tipeTunggakan()->where('id_administrasi', $mTunggakan->id_tunggakan)->first();
                        $cicilanTahapAdmTgg = 0;
                        if ($tCicilan != null) {
                            $jsonDesk = json_decode($tCicilan->deskripsi);
                            if ($jsonDesk == null) {
                                $cicilanTahapAdmTgg = 1;
                                $tCicilan->deskripsi = json_encode([$nominalTunggakanBayar]);
                            } else {
                                $cicilanTahapAdmTgg = count($jsonDesk) + 1;
                                $tCicilan->deskripsi = json_encode(array_push($jsonDesk, $nominalTunggakanBayar));
                            }
                            $tCicilan->update();
                        }
                        

                        $detailTunggakan[] = [
                            'nama_biaya' => $request->nama_biaya_tunggakan[$j] . " tahap ke " . $cicilanTahapAdmTgg,
                            'nominal' => $nominalTunggakanBayar,
                            'id_jenis_administrasi' => $key,
                            'ajaran' => $ajaranLalu
                        ];

                        //update rekap
                        $this->saveRekapTunggakan($request->nama_biaya_tunggakan[$j],$ajaranLalu, $nominalTunggakanBayar);

                        if ($ajaranLalu != $strukWA_ajaranBefore) {
                            $strukWA .= "\n";
                            $strukWA .= "*Tanggungan pada TA " . $ajaranLalu . "* \n";
                            $strukWA_ajaranBefore = $ajaranLalu;
                        }
                        $strukWA .= $strukWA_noBefore . ". " . $request->nama_biaya_tunggakan[$j] . " Rp. " . $request->nominal_tunggakan[$j] . " tahan ke " . $cicilanTahapAdmTgg . " \n";
                        $strukWA_noBefore++;
                    }
                    
                    $j++;
                }
            }
            
    
            $strukWA .= "\n*Total* \n";
            $strukWA .= "Rp ".$this->ribuan($total)." \n\n";
            $strukWA .= "*Uang Diterima* \n";
            $strukWA .= "Rp ". $this->nullToNol($request->nominal_pembayaran) ." \n\n";
            $strukWA .= "*Uang Kembalian* \n";
            $strukWA .= "Rp ". $this->nullToNol($request->sisa_uang)." ";

            // dd($strukWA);
            
            $masterWa = new MWhatsapp;
            $masterWa->no_telp = $siswa->no_telp;
            $masterWa->pesan = $strukWA;
            $masterWa->tipe = 1;
            //whatsapp --------------------------------------------------------------------------
            $msg = $strukWA;
            try {
                //code...
                $resWa = Http::post(env("HOST_WAGATEWAY")."/send-message?number=". $siswa->no_telp . "@c.us&msg=". $msg);
                if ($resWa->successful()) {
                    $masterWa->status = 1;
                } else {
                    $masterWa->status = 2;
                }
            } catch (\Throwable $th) {
                $masterWa->status = 2;
            }
            // dd($res);
            $masterWa->save();
            // dd($total);
            // -----------------------------------------------------------------------------------
            $hTransaksi = HTransaksi::create([
                'kode' => "SIA-".$this->generateRandomString(15),
                'id_siswa' => $id_siswa,
                'biaya' => json_encode($detailBiaya),
                'tunggakan' => json_encode($detailTunggakan),
                'terbayar' => str_replace(".", "", $request->nominal_pembayaran),
                'total' => $total
            ]);
            // dd($idTransaksi);
            
        //-------------------------------------------------------------------------------------------
            return response()->json(['status' => true, 'msg' => "Sukses Membayar","data" => encrypt($hTransaksi->id_transaksi)], 200);
        // } catch (\Throwable $th) {
        //     return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        // }
        // dd("done");
    }
    function getSppBulanan($id_siswa,$bulan)
    {
        try {
            //code...
            $spp = TSPP::where("id_siswa",decrypt($id_siswa))->first();
            if($spp != null){
                return response()->json(['status'=>true,'data'=>$spp->{$bulan}]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => true, 'msg'=>$th->getMessage()]);
        }
    }
    public function saveRekap($idJenisAdm,$id_kelas,$bayar)
    {
        $mRekap = MRekap::where('id_jenis_administrasi', $idJenisAdm)->where('id_kelas', $id_kelas)->first();
        $mRekap->total = $mRekap->total + $bayar;
        $mRekap->update();
    }
    public function saveRekapTunggakan($namaTunggakan,$ajaran,$bayar)
    {
        $mRekapTunggakan = MRekapTunggakan::where('nama_tunggakan', $namaTunggakan)->where('ajaran', $ajaran)->first();
        $mRekapTunggakan->total = $mRekapTunggakan->total + $bayar;
        $mRekapTunggakan->update();
    }
}
