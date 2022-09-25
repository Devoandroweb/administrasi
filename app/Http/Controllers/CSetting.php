<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use App\Models\TCicilan;
use App\Models\TSPP;
use App\Traits\Administrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CSetting extends Controller
{
    use Administrasi;
    function resetTahunAjaran()
    {
        // try {
            // ambil data
            $alumni = MKelas::where("no_urut",0)->first();
            $idSpp = MJenisAdministrasi::where("nama", "SPP")->orWhere("nama", "spp")->pluck('id')->toArray();
            $mSiswa = MSiswa::with('kelas')->where('id_kelas', '!=', 0)->get();
            $mKelas = MKelas::all();
            //cek tahun ajaran
            TSPP::truncate();
            $mAjaran = MAjaran::orderBy('tahun_akhir', 'desc')->first();
            $tahunAwalBaru = (int)$mAjaran->tahun_akhir;
            $tahunAkhirBaru = (int)$mAjaran->tahun_akhir + 1;

            //pindahkan administrasi ke tunggakan
            $mAdm = Siswa::with('jenisAdministrasi')->get();
            foreach ($mAdm as $adm) {
                //masukkan ke tunggakan
                $mTunggakan = MTunggakan::create([
                    'id_siswa' => $adm->id_siswa,
                    'nama_tunggakan' => $adm->jenisAdministrasi->nama,
                    'nominal' => $adm->nominal,
                    'ajaran' => Session::get('tahun_awal') . " - " . Session::get('tahun_akhir')
                ]);
                //masukkan ke t_cicilan
                TCicilan::create([
                    'tipe' => 2,
                    'id_administrasi' => $mTunggakan->id_tunggakan
                ]);
            }



            //naikkan siswa ke kelas
            

            foreach ($mSiswa as $siswa) {
                if ((int)$siswa->kelas->indikasi == 12) {
                    $siswa->update(['id_kelas' => $alumni->id_kelas,'status'=> 0]);
                } elseif ((int)$siswa->kelas->indikasi == 11) {
                    $siswa->update(['id_kelas' => $this->cariKelas($mKelas, 12, $siswa->kelas->jurusan->id_jurusan)]);
                } elseif ((int)$siswa->kelas->indikasi == 10) {
                    $siswa->update(['id_kelas' => $this->cariKelas($mKelas, 11, $siswa->kelas->jurusan->id_jurusan)]);
                }
            }
            // die();
            //update ajaran
            $mAjaran->tahun_awal = $tahunAwalBaru;
            $mAjaran->tahun_akhir = $tahunAkhirBaru;
            MAjaran::query()->update(['status' => 0]);
            $ajaran = MAjaran::create([
                'tahun_awal' => $tahunAwalBaru,
                'tahun_akhir' => $tahunAkhirBaru,
                'status' => 1
            ]);
            $_SESI_AJARAN = [];
            if ($ajaran != null) {
                $_SESI_AJARAN['tahun_awal'] = $ajaran->tahun_awal;
                $_SESI_AJARAN['tahun_akhir'] = $ajaran->tahun_akhir;
            }
            Session::put($_SESI_AJARAN);
            //truncate
            Siswa::truncate();
            TCicilan::where('tipe', 1)->delete();

            // add to administrasi
            $mJenisAdm = MJenisAdministrasi::all();
            $mSiswaAfterUp = MSiswa::where('id_kelas','!=', $alumni->id_kelas)->get();
            
            foreach ($mSiswaAfterUp as $siswaAfterUp) {
                $this->createAdministrasi($siswaAfterUp->id_siswa, $siswaAfterUp->id_kelas, $idSpp);
            }
            //foreach ($mSiswaAfterUp as $siswaAfterUp) {
            //     $adm = null;
            //     foreach ($mJenisAdm as $jenisAdm) {
            //         if($siswaAfterUp->id_kelas == $jenisAdm->id_kelas){
            //             if(in_array($jenisAdm->id,$idSpp)){
            //                 $spp = (int)$jenisAdm->biaya;
            //                 $biaya = (int)$jenisAdm->biaya * 12;
            //                 TSPP::create([
            //                     'id_siswa' => $siswaAfterUp->id_siswa,
            //                     'januari' => $spp,
            //                     'februari' => $spp,
            //                     'maret' => $spp,
            //                     'april' => $spp,
            //                     'mei' => $spp,
            //                     'juni' => $spp,
            //                     'juli' => $spp,
            //                     'agustus' => $spp,
            //                     'september' => $spp,
            //                     'oktober' => $spp,
            //                     'november' => $spp,
            //                     'desember' => $spp
            //                 ]);
            //             }else{
            //                 $biaya = (int)$jenisAdm->biaya;
            //             }
            //             $adm[] = [
            //                 'id_siswa' => $siswaAfterUp->id_siswa,
            //                 'id_jenis_administrasi' => $jenisAdm->id,
            //                 'nominal' => $biaya,
            //             ];
            //             Siswa::insert($adm);
            //         }
            //     }
            // }

            return response()->json(['status' => true, 'msg' => 'success tahun ajaran baru ' . $tahunAwalBaru],200);
        // } catch (\Throwable $th) {
        //     return response()->json(['status' => false, 'msg' => $th->getMessage()],500);

        // }
    }
    function cariKelas($mKelas,$kelas,$id_jurusan)
    {
        foreach($mKelas as $key){
            if((int)$key->indikasi == (int)$kelas && (int)$key->id_jurusan == $id_jurusan){
                return $key->id_kelas;
            }
        }
        return 0;
    }
}
