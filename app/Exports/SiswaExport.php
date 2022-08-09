<?php

namespace App\Exports;

use App\Models\MSiswa;
use App\Traits\Helper;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithStyles, ShouldAutoSize
{
    use Helper;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MSiswa::select('nis','nama','tempat_lahir','tgl_lahir','alamat','jk','no_telp')->get();
    }
    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nama,
            $siswa->tempat_lahir,
            $this->convertDate($siswa->tgl_lahir,true,false),
            $this->chooseGender($siswa->jk),
            $siswa->alamat,
            $siswa->no_telp,
        ];
    }
    public function headings(): array
    {
        return ["NIS","Nama", "Tempat Lahir", "Tanggal Lahir","Jenis Kelamin","Alamat","No Telp"];
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

        ];
    }
    
}
