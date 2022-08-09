<?php

namespace App\Exports;

use App\Models\Administrasi\MPendanaan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class PengeluaranExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function view(): view
    {
        // dd(MAjaran::select('tahun_awal', 'tahun_akhir')->get()->toArray());
        $pengeluaran = MPendanaan::select('detail', 'total', 'created_at')->where('tipe',2)->get();

        return view('pages.report.pengeluaran', [
            'pengeluaran' => $pengeluaran
        ]);
    }
}
