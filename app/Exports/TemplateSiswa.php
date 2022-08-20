<?php

namespace App\Exports;

use App\Models\MJenisAdministrasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class TemplateSiswa implements WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $mJenisAdministrasi = MJenisAdministrasi::pluck('nama')->toArray();
        // dd($mJenisAdministrasi);
        $header = ["NISN", "Nama", "Tempat Lahir", "Tanggal Lahir", "Jenis Kelamin","No Telp","Kelas","Alamat"];
        foreach($mJenisAdministrasi as $key){
            array_push($header, $key);
        }
        return $header;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

        ];
    }
}
