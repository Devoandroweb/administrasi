<?php

namespace App\Http\Controllers;

use App\Exports\AdministrasiSiswaExport;
use App\Exports\PemasukanExport;
use App\Exports\PengeluaranExport;
use App\Exports\SiswaExport;
use App\Models\Administrasi\MPendanaan;
use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class CExport extends Controller
{
    public function exportSiswa()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
    public function exportAdministrasiSiswa()
    {
        return Excel::download(new AdministrasiSiswaExport, 'siswa-administrasi-siswa.xlsx');
    }
    public function exportPengeluaran()
    {
        return Excel::download(new PengeluaranExport, 'pengeluaran.xlsx');

    } 
    public function exportPemasukan()
    {
        return Excel::download(new PemasukanExport, 'pemasukan.xlsx');

    }
}
