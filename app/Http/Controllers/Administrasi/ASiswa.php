<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use Illuminate\Http\Request;

class ASiswa extends Controller
{
    function index()
    {
        $title = "Siswa";
        return view('pages.administrasi.siswa.index', compact('title'));
    }
    function tunggakan($id)
    {
        $id_siswa = decrypt($id);
        $siswa = MSiswa::where('id_siswa',$id_siswa)->with('kelas')->first();
        $data = MTunggakan::where('id_siswa',$id_siswa)->get();
        return view('pages.administrasi.siswa.tunggakan',compact('siswa','data'))->with('title','Tunggakan Siswa '.$siswa->nama);
    }
}
