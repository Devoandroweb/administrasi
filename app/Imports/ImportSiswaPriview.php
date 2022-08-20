<?php

namespace App\Imports;

use App\Traits\Helper;
use App\Traits\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
class ImportSiswaPriview implements ToCollection, WithChunkReading, WithStartRow
{
    use Helper;
    use Kelas;
    protected $data = [];
    protected $msg = "";
    protected $kelasValid = 0;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        $isFirst = true;
        foreach ($collection as $row) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            } 
            $statusKelas = $this->searchKelas($row[6]); // jika kelas tidak ada maka hasilnya 1
            $this->kelasValid = $this->kelasValid + $statusKelas;
            $this->data[] = [
                'nisn' => $row[0],
                'nama' => $row[1],
                'tempat_lahir' => $this->nullToStrip($row[2]),
                'tgl_lahir' => $this->convertDate(date("Y-m-d",strtotime($this->convertDateToSystem($row[3]))), false, false),
                'jk' => $row[4],
                'no_telp' => $row[5],
                'kelas' => $row[6],
                'alamat' => $row[7],
                'status_row' => $statusKelas
            ];
        }
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function startRow(): int
    {
        return 1;
    }
    public function getData()
    {
        return $this->data;
    }
    public function message()
    {
        return $this->msg = "Ada ". $this->kelasValid . " Kelas tidak Valid";
    }
}
