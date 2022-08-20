<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\BeforeSheet;

class RekapExport implements WithMultipleSheets, WithStyles,WithDrawings
{
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new RekapExportNow();
        $sheets[] = new RekapExportPrior();

        return $sheets;
    }
    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A')->getAlignment()->setVertical('center');
        return $sheet;
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/img/logo_sekolah.png'));
        $drawing->setHeight(2);
        $drawing->setCoordinates('C1');

        return $drawing;
    }
    public static function beforeSheet(BeforeSheet $event)
    {
        return $event->sheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    }
}
