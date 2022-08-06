<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use App\Models\MWhatsapp;
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
            $siswa = MSiswa::find($id_siswa)->first();
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
            $strukWA = "Terima Kasih,\r\n";
            $strukWA .= "Pembayaran atas nama :\r\n*". $siswa->nama. "* \r\ntelah kami terima.\r\n\r\n";

            $strukWA .= "Dengan detail pembayaran sebagai berikut: \r\n\r\n";
            $strukWA .= "------------------------------------------------- \r\n\r\n";
            //----------------------------------------------------------------------------
            if(isset($request->id_jenis_administrasi)){

                foreach($request->id_jenis_administrasi as $key){
                    if($request->nominal[$i] != 0){
                        $total = $total + (int)str_replace(".", "", $request->nominal[$i]);
                        $detailBiaya[] = [
                            'nama_biaya' => $request->nama_biaya[$i],
                            'nominal' => (int)str_replace(".", "", $request->nominal[$i]),
                            'ajaran' => $ajaranNow
                        ];
                        if($ajaranNow != $strukWA_ajaranNow){
                            $strukWA .= "# Tanggungan Pada Tahun Ajaran ". $ajaranNow." # \r\n";
                            $strukWA_ajaranNow = $ajaranNow;
                        }
                        $strukWA .= $strukWA_noNow.". ". $request->nama_biaya[$i]." Rp. ". $request->nominal[$i]." \r\n";
                        $strukWA_noNow++;
                    }
                    $nominal = (int)str_replace(".","",$request->biaya[$i]) - (int)str_replace(".","",$request->nominal[$i]);
                    Siswa::where('id_jenis_administrasi',$key)->where('id_siswa',$id_siswa)->update(['nominal'=> $nominal]);
                    $i++;
                }
            }
            if(isset($request->nama_biaya_tunggakan)){
                
                foreach($request->nama_biaya_tunggakan as $key){
                    if ($request->nominal_tunggakan[$j] != 0) {
                        $total = $total + (int)str_replace(".", "", $request->nominal_tunggakan[$i]);
                        $ajaranLalu = $request->tahun_ajaran[$j];
                        $detailTunggakan[] = [
                            'nama_biaya' => $request->nama_biaya_tunggakan[$j],
                            'nominal' => (int)str_replace(".", "", $request->nominal_tunggakan[$j]),
                            'ajaran' => $ajaranLalu
                        ];
                        if ($ajaranLalu != $strukWA_ajaranBefore) {
                            $strukWA .= "\r\n";
                            $strukWA .= "# Tanggungan Pada Tahun Ajaran " . $ajaranLalu . " # \r\n";
                            $strukWA_ajaranBefore = $ajaranLalu;
                        }
                        $strukWA .= $strukWA_noBefore . ". " . $request->nama_biaya_tunggakan[$j] . " Rp. " . $request->nominal_tunggakan[$j] . " \r\n";
                        $strukWA_noBefore++;
                    }
                    $nominal = (int)str_replace(".","",$request->biaya_tunggakan[$j]) - (int)str_replace(".","",$request->nominal_tunggakan[$j]);
                    MTunggakan::where('nama_tunggakan',$key)->where('id_siswa',$id_siswa)->where('ajaran',$request->tahun_ajaran[$j])->update(['nominal'=> $nominal]);
                    $j++;
                }
            }
            
            $strukWA .= "\r\n";
            $strukWA .= "# Total #\r\n";
            $strukWA .= "Rp. ".$this->ribuan($total)." \r\n\r\n";

            $strukWA .= "# Uang Diterima #\r\n";
            $strukWA .= "Rp. ". $request->nominal_pembayaran ." \r\n\r\n";

            $strukWA .= "# Uang Kembalian #\r\n";
            $strukWA .= "Rp. ". $request->sisa_uang." \r\n\r\n";

            // dd($strukWA);
            $masterWa = new MWhatsapp;
            $masterWa->no_telp = "6285608727991";
            $masterWa->pesan = $strukWA;
            $masterWa->tipe_file = 1;
            //whatsapp --------------------------------------------------------------------------
            try {
                Http::get("http://localhost:8000/send-message", [
                    'number' => $siswa."@c.us",
                    'msg' => $strukWA
                ]);
                $masterWa->status = 1;
                // dd($res);
            } catch (\Throwable $th) {
                //throw $th;
                $masterWa->status = 2;
            }
            $masterWa->save();
            // -----------------------------------------------------------------------------------
            HTransaksi::create([
                'kode' => 0,
                'id_siswa' => $id_siswa,
                'biaya' => json_encode($detailBiaya),
                'tunggakan' => json_encode($detailTunggakan),
                'terbayar' => $request->nominal_pembayaran,
            ]);
            
            
        //-------------------------------------------------------------------------------------------
            return response()->json(['status' => true, 'msg' => "Sukses Membayar"], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
        // dd("done");
    }
}
