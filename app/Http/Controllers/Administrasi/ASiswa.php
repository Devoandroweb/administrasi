<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use App\Models\TCicilan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ASiswa extends Controller
{
    function index()
    {
        $title = "Siswa";
        $kelas = MKelas::with('jurusan')->orderBy('indikasi','asc')->get();
        return view('pages.administrasi.siswa.index', compact('title','kelas'));
    }
    function tunggakan($id)
    {
        $id_siswa = decrypt($id);
        $siswa = MSiswa::where('id_siswa',$id_siswa)->with('kelas')->first();
        $data = MTunggakan::where('id_siswa',$id_siswa)->get();
        return view('pages.administrasi.siswa.tunggakan',compact('siswa','data'))->with('title','Tunggakan Siswa '.$siswa->nama);
    }
    function cicilan($id)
    {
        $id_siswa = decrypt($id);
        $siswa = MSiswa::where('id_siswa', $id_siswa)->with('kelas')->first();
        $administrasi = DB::select("SELECT * FROM `administrasi` INNER JOIN t_cicilan ON administrasi.id_administrasi = t_cicilan.id_administrasi INNER JOIN m_jenis_administrasi ON m_jenis_administrasi.id = administrasi.id_jenis_administrasi WHERE tipe = 1 AND administrasi.id_siswa = {$id_siswa} ;");
        $tunggakan = DB::select("SELECT * FROM `administrasi` INNER JOIN t_cicilan ON administrasi.id_administrasi = t_cicilan.id_administrasi INNER JOIN m_jenis_administrasi ON m_jenis_administrasi.id = administrasi.id_jenis_administrasi WHERE tipe = 2 AND administrasi.id_siswa = {$id_siswa} ;");
        // $tunggakan = DB::statement('SELECT * FROM `administrasi` INNER JOIN t_cicilan ON administrasi.id_administrasi = t_cicilan.id_administrasi WHERE tipe = 2;');
        // $tunggakan = MTunggakan::where('id_siswa', $id_siswa)->with('cicilan')->get();
        $ajaran = MAjaran::whereNot('status', 1)->get();
        // dd($administrasi);
        return view('pages.administrasi.siswa.cicilan', compact('siswa', 'administrasi', 'tunggakan','ajaran'))->with('title', 'Cicilan Siswa ' . $siswa->nama);
    }
    function printTanggungan($id_siswa)
    {
        $id = decrypt($id_siswa);
        $siswa = MSiswa::find($id);
        $biayaNow = Siswa::where('id_siswa', $siswa->id_siswa)->with('jenisAdministrasi')->get();
        $biayaBefore = MTunggakan::where('id_siswa', $siswa->id_siswa)->get();
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'calibri']);
        $pdf = Pdf::loadView('pages.administrasi.siswa.cetak_tanggungan', compact('biayaNow', 'biayaBefore','siswa'));
        return $pdf->download('administrasi-' . $siswa->nisn . '-' . $siswa->nama . '-' . date('YmdHis') . '.pdf');
        // return view('pages.client.cetak_tanggungan');
    }
}
