<?php

namespace App\Exports;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Siswa;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\BeforeSheet;
class RekapPerSiswaExport implements FromView, ShouldAutoSize, WithTitle, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function view(): view
    {
        $administrasi = Siswa::all();
        $terbayar = HTransaksi::all();
        $tunggakan = MTunggakan::all();
        $siswa = MSiswa::all();
        return view('pages.report.rekap-per-siswa', compact('administrasi', 'terbayar', 'siswa', 'tunggakan'));
    }
    public function title(): string
    {
        return 'Rekap Per Siswa';
    }
    public function columnFormats(): array
    {
        return [
            'E:END' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
    public static function beforeSheet(BeforeSheet $event)
    {
        $event->sheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    }
}
