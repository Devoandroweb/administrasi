<?php

namespace App\Http\Controllers;

use App\Exports\AdministrasiSiswaExport;
use App\Exports\HPembayaranExport;
use App\Exports\PemasukanExport;
use App\Exports\PengeluaranExport;
use App\Exports\RekapExport;
use App\Exports\RekapPerSiswaExport;
use App\Exports\SiswaExport;
use App\Exports\TemplateSiswa;
use App\Models\Administrasi\HTransaksi;
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
    public function exportSiswaTemplate()
    {
        return Excel::download(new TemplateSiswa, 'siswa-template.xlsx');
    }
    public function exportRekap()
    {
        return Excel::download(new RekapExport, 'rekap-'. date("dmY-His").'.xlsx');
        // return view("pages.report.rekap");
        // return view("pages.report.rekap-tanggungan-sebelumnya");
    }
    public function exportHTransaksi()
    {
        return Excel::download(new HPembayaranExport, 'riwayat-transaksi-'. date("dmY-His").'.xlsx');
    }
    public function exportRekapPerSiswa()
    {
        return Excel::download(new RekapPerSiswaExport, 'rekap-per-siswa-' . date("dmY-His") . '.xlsx');
    }


}
