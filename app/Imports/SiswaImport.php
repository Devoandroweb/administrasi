<?php

namespace App\Imports;

use App\Traits\Helper;
use App\Traits\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToCollection, WithStartRow
{
    use Helper;
    use Kelas;
    protected $data = [];
    protected $jenisAdm = [];
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $isFirst = true;
        foreach ($collection as $row) {
            if($isFirst){
                for ($i = 8; $i < 100; $i++) {
                    if (isset($row[$i])) {
                        array_push($this->jenisAdm, $row[$i]);
                    } else {
                        break;
                    }
                }
            }
            $isFirst = false;
        }
        //hilangkan index ke 1
        $isFirst = true;
        // dd($collection);
        foreach ($collection as $row) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            }
            if($row[0] != null || $row[1] != null){
                $this->data[] = [
                    'nisn' => $row[0],
                    'nama' => $row[1],
                    'tempat_lahir' => $this->nullToStrip($row[2]),
                    'tgl_lahir' => date("Y-m-d", strtotime($this->convertDateToSystem($row[3]))),
                    'jk' => $row[4],
                    'no_telp' => $row[5],
                    'id_kelas' => $this->searchKelasId($row[6]),
                    'alamat' => $row[7],
                    'username' => $row[0],
                    'password' => Hash::make("12345"),
                    'administrasi' => $this->generateAdministrasi($row),
                ];
            }

        }
    }
 
    public function startRow(): int
    {
        return 1;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getJenisAdministrasi()
    {
        return $this->jenisAdm;
    }
    private function generateAdministrasi($row)
    {
        $adm = [];
        $i = 8;
        // dd($this->jenisAdm);
        foreach($this->jenisAdm as $ja){
            array_push($adm,[
                'nama_biaya' => $ja,
                'nominal' => $row[$i]
            ]);
            $i++;
        }
        return $adm;
    }
}
