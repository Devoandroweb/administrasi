<?php

namespace App\Traits;


use App\Models\MSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

trait Helper
{
    static function convertDate($tgl, $tampil_hari = true, $with_menit = true)
    {
        if ($tgl != null ||  $tgl != "") {
            $nama_hari    =   array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
            $nama_bulan   =   array(
                1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            );
            $tahun        =   substr($tgl, 0, 4);
            $bulan        =   $nama_bulan[(int)substr($tgl, 5, 2)];
            $tanggal      =   substr($tgl, 8, 2);

            $text         =   "";

            if ($tampil_hari) {

                $urutan_hari  =   date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
                $hari         =   $nama_hari[$urutan_hari];
                $text         .=  $hari . ", ";
            }

            $text         .= $tanggal . " " . $bulan . " " . $tahun;

            if ($with_menit) {

                $jam    =   substr($tgl, 11, 2);
                $menit  =   substr($tgl, 14, 2);

                $text   .=  ", " . $jam . ":" . $menit;
            }
        } else {

            $text = "-";
        }
        return $text;
    }
    static function ribuan($angka, $comma = 0)
    {

        $hasil_rupiah = number_format($angka, $comma, ',', '.');
        return $hasil_rupiah;
    }
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    static function searchData($column1, $column2, $table, $value)
    {
        $listDefault = DB::table($table)->where('deleted', 1)->get([$column1, $column2]);
        $result = "";

        foreach ($listDefault as $key) {
            if ($key->{$column1} == $value) {
                $result = $key->{$column2};
                return $result;
            }
        }
        return $result;
    }
    static function showData($data, $column)
    {
        $columnDate = ['tgl_lahir'];

        if ($data != null) {
            return $data->{$column};
        } else {
            if (old($column)) {
                if (in_array($column, $columnDate)) {
                    return date('Y-m-d', strtotime(old($column)));
                } else {
                    return old($column);
                }
            }
        }
    }
    static function showDataDate($data, $column)
    {
        $columnDate = ['tgl_lahir'];
        if ($data != null) {
            if (strtotime($data->{$column})) {
                return date('Y-m-d', strtotime($data->{$column}));
            } else {
                return $data->{$column};
            }
        } else {
            if (old($column)) {
                if (in_array($column, $columnDate)) {
                    return date('Y-m-d', strtotime(old($column)));
                } else {
                    return old($column);
                }
            }
        }
    }
    static function showDataSelected($data, $column, $value)
    {
        if ($data != null) {
            if ($data->{$column} == $value) {
                return 'selected';
            };
        }
    }
    static function showDataSelected2($data, $column, $value)
    {
        if ($data !== null) {
            if ($data->{$column} === $value) {
                return 'selected';
            };
        }
    }
    static function showDataSelect2($data, $column1, $column2, $table)
    {
        if ($data != null) {
            // dd("dsadas");
            $result = Helper::searchData($column1, $column2, $table, $data->{$column1});

            return "<option value='{$data->{$column1}}' selected>" . $result . "</option>";
        } else {
            if (old($column1)) {
                $result = Helper::searchData($column1, $column2, $table, old($column1));
                return "<option value='" . old($column1) . "' selected>" . $result . "</option>";
            }
        }
    }
    static function showDataChecked($data, $column, $value)
    {
        if ($data != null) {
            if ($data->{$column} == $value) {
                return 'checked';
            };
        }
    }

    static function showDataChecked2($data, $column, $value)
    {
        if ($data != null) {
            foreach ($data as $a) {
                if ($a->{$column} == $value) {
                    return 'checked';
                };
            }
        }
    }

    static function singkatAngka($n, $presisi = 1)
    {
        if ($n < 900) {
            $format_angka = number_format($n, $presisi);
            $simbol = '';
        } else if ($n < 900000) {
            $format_angka = number_format($n / 1000, $presisi);
            $simbol = 'rb';
        } else if ($n < 900000000) {
            $format_angka = number_format($n / 1000000, $presisi);
            $simbol = 'jt';
        } else if ($n < 900000000000) {
            $format_angka = number_format($n / 1000000000, $presisi);
            $simbol = 'M';
        } else {
            $format_angka = number_format($n / 1000000000000, $presisi);
            $simbol = 'T';
        }

        if ($presisi > 0) {
            $pisah = '.' . str_repeat('0', $presisi);
            $format_angka = str_replace($pisah, '', $format_angka);
        }

        return $format_angka . $simbol;
    }
    static function replaceNumeric($nominal)
    {
        return str_replace(".", "", $nominal);
    }
    static function convertBulan($value)
    {
        if ($value != null) {
            $nama_bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        } else {
            return "-";
        }
        return $nama_bulan[$value - 1];
    }
    static function getMinutes($value)
    {
        //15 - 23
        $hours = date("H", $value);
        $minutes = date("i", $value);
        $seconds = date("s", $value);
        $result = 0;
        if (intval($hours) > 0) {
            $result += intval($hours) * 60;
        }
        if ($minutes > 0) {
            $result += intval($minutes);
        }
        if ($seconds > 0) {
            $result += intval($seconds) / 60;
        }
        return $result;
    }
    static function includeAsJsString($template)
    {
        $string = view($template);
        return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
    }
    static function convertRole($role)
    {
        switch ($role) {
            case 1:
                return '<div class="badge badge-info">Admin</div>';
                break;
            case 2:
                return '<div class="badge badge-success">Bendahara</div>';
                break;
            case 3:
                return '<div class="badge badge-danger">Kepala Sekolah</div>';
                break;
            default:
                return "-";
                break;
        }
    }
    static function newNis()
    {
        $latesNis = MSiswa::max('nis');
        $newNis = $latesNis + 1;
        return $newNis;
    }
   
}
