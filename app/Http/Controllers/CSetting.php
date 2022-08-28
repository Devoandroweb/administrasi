<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
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
        try {
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
            $mSiswa = MSiswa::with('kelas')->where('id_kelas', '!=', 0)->get();
            $mKelas = MKelas::all();
            foreach ($mSiswa as $siswa) {
                if ((int)$siswa->kelas->indikasi == 12) {
                    $siswa->update(['id_kelas' => 0,'status'=> 0]);
                } elseif ((int)$siswa->kelas->indikasi == 11) {
                    $this->createAdministrasi($siswa->id_siswa);
                    $siswa->update(['id_kelas' => $this->cariKelas($mKelas, 12)]);
                } elseif ((int)$siswa->kelas->indikasi == 10) {
                    $this->createAdministrasi($siswa->id_siswa);
                    $siswa->update(['id_kelas' => $this->cariKelas($mKelas, 11)]);
                }
            }
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
            
            
            return response()->json(['status' => true, 'msg' => 'success tahun ajaran baru ' . $tahunAwalBaru],200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()],500);

        }
    }
    function cariKelas($mKelas,$kelas)
    {
        foreach($mKelas as $key){
            if((int)$key->indikasi == (int)$kelas){
                return $key->id_kelas;
            }
        }
        return 0;
    }
}
