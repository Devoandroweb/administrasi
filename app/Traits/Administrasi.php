<?php

namespace App\Traits;

use App\Models\Administrasi\MPendanaan;
use App\Models\Administrasi\Siswa;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MRekap;
use App\Models\MSaldo;
use App\Models\TCicilan;
use App\Models\TSPP;


trait Administrasi
{
    use Saldo;
    function createAdministrasi($id_siswa,$id_kelas, $idSpp = [])
    {
        $jenisAdmistrasi = MJenisAdministrasi::where('id_kelas',$id_kelas)->get();
        $spp = 0;
        $idSpp = MJenisAdministrasi::where("nama", "SPP")->orWhere("nama", "spp")->pluck('id')->toArray();
        
        foreach ($jenisAdmistrasi as $key) {
            // echo $id_kelas." == ".$key->id_kelas."<br>";
            if (in_array($key->id, $idSpp)) {
                $spp = $key->biaya;
                $siswaAdm = Siswa::create(['id_siswa' => $id_siswa, 'id_jenis_administrasi' => $key->id, 'nominal' => $key->biaya * 12]);
            } else {
                $siswaAdm = Siswa::create(['id_siswa' => $id_siswa, 'id_jenis_administrasi' => $key->id, 'nominal' => $key->biaya]);
            }
            TCicilan::create([
                'tipe' => 1,
                'id_administrasi' => $siswaAdm->id_administrasi
            ]);
        }
        
        // dd($dataAdm);
        TSPP::create([
            'id_siswa' => $id_siswa,
            'januari' => $spp,
            'februari' => $spp,
            'maret' => $spp,
            'april' => $spp,
            'mei' => $spp,
            'juni' => $spp,
            'juli' => $spp,
            'agustus' => $spp,
            'september' => $spp,
            'oktober' => $spp,
            'november' => $spp,
            'desember' => $spp
        ]);
    }
    static function updateRekap()
    {
        //ambil jenis adm
        $mJenisAdm = MJenisAdministrasi::all();
        $mKelas = MKelas::all();
        foreach ($mJenisAdm as $jenisAdm) {
            foreach ($mKelas as $kelas) {
                MRekap::create([
                    'id_jenis_administrasi' => $jenisAdm->id,
                    'id_kelas' => $kelas->id_kelas,
                    'total' => 0
                ]);
            }
        }
    }
    static function createRekap($mJenisAdm)
    {
        $mKelas = MKelas::all();
        $dataRekap = [];
        foreach ($mKelas as $kelas) {
            $dataRekap[] = [
                'id_jenis_administrasi' => $mJenisAdm->id,
                'id_kelas' => $kelas->id_kelas,
            ];
        }
        MRekap::insert($dataRekap);
    }
    function createPemasukan($tipePemasukan,$nama,$detail,$total)
    {
        $pemasukan = array(
            'tipe' => 1,
            'tipe_pemasukan' => $tipePemasukan,
            'nama' => $nama,
            'detail' => json_encode($detail),
            'total' => $total,
            'saldo' => $this->updateSaldo($total),
        );
        MPendanaan::insert($pemasukan);
    }
    
}