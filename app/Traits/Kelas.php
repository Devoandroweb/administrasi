<?php

namespace App\Traits;

use App\Models\MKelas;


trait Kelas{
    static function searchKelas($value)
    {
        $mKelas = MKelas::with('jurusan')->get();
        $value = explode(" ", $value);
        if (count($value) != 2) {
            return 1;
        }
        $nama = $value[0];
        $jurusan = $value[1];
        foreach ($mKelas as $kelas) {
            if ($nama == $kelas->nama && $jurusan == $kelas->jurusan->nama) {
                return 0;
            }
        }
        return 1;
    }
    static function searchKelasId($value)
    {
        $mKelas = MKelas::with('jurusan')->get();
        $value = explode(" ", $value);
        if (count($value) != 2) {
            return 0;
        }
        $nama = $value[0];
        $jurusan = $value[1];
        foreach ($mKelas as $kelas) {
            if ($nama == $kelas->nama && $jurusan == $kelas->jurusan->nama) {
                return $kelas->id_kelas;
            }
        }
        return 0;
    }
}
