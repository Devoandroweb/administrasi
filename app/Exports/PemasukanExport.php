<?php

namespace App\Exports;

use App\Models\Administrasi\MPendanaan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class PemasukanExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function view(): view
    {
        // dd(MAjaran::select('tahun_awal', 'tahun_akhir')->get()->toArray());
        $pemasukan = MPendanaan::select('tipe_pemasukan','id_siswa', 'nama', 'detail', 'total','created_at')
        ->where('tipe',1)
        ->orderBy('created_at','asc')
        ->with('siswa')->get();
        // dd($pemasukan);
        return view('pages.report.pemasukan', [
            'pemasukan' => $pemasukan
        ]);
    }
}
