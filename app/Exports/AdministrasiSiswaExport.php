<?php

namespace App\Exports;

use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class AdministrasiSiswaExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function view(): view
    {
        // dd(MAjaran::select('tahun_awal', 'tahun_akhir')->get()->toArray());
        return view('pages.report.report-administrasi-siswa', [
            'siswas' => MSiswa::with('kelas', 'admSiswa', 'tunggakan')->get(),
            'ajarans' => MAjaran::select('tahun_awal','tahun_akhir')->orderBy("tahun_awal","DESC")->get()->toArray(),
            'administrasis' => Siswa::with('jenisAdministrasi')->get(),
        ]);
    }
}
