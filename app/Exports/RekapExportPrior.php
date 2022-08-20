<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\BeforeSheet;

class RekapExportPrior implements FromView, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function view(): view
    {
        return view('pages.report.rekap-tanggungan-sebelumnya');
    }
    public function title(): string
    {
        return 'Sebelumnya';
    }
    public function columnFormats(): array
    {
        return [
            'B:END' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
    public static function beforeSheet(BeforeSheet $event)
    {
        $event->sheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    }
}
