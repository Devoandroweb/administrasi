<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<style>
     table{
        border-collapse: collapse;
        border: 1px solid black;
    }
    table th{
        text-transform: uppercase;
    }
    table th,td{
        padding: 0.2rem 0.5rem !important;
        border: 1px solid black !important;
        height: 30px !important;
    }
</style>
@php
    use App\Traits\Helper;

    function terbayar($terbayar,$idsiswa,$tipe)
    {
        $total = 0;
        foreach ($terbayar as $ter) {
            if($ter->id_siswa == $idsiswa){
                if($tipe == 1){ // biaya
                    $biaya = json_decode($ter->biaya);
                    foreach ($biaya as $biay) {
                        $total += (int)$biay->nominal;
                    }
                }elseif($tipe == 2){ // tunggakan
                    $tunggakan = json_decode($ter->tunggakan);
                    foreach ($tunggakan as $tgg) {
                        $total += (int)$tgg->nominal;
                    }
                }
            }
        }
        return $total;
    }
    function kurangAdm($administrasi,$idsiswa)
    {
        $total = 0;
        foreach ($administrasi as $adm) {
            if($adm->id_siswa == $idsiswa){
                $total += $adm->nominal;
            }
        }
        return  $total;
    }
    function kurangTgg($tunggakan,$idsiswa)
    {
        $total = 0;
        foreach ($tunggakan as $tgg) {
            if($idsiswa == $tgg->id_siswa){
                $total += $tgg->nominal;
            }
        }
        return  $total;
    }
@endphp
    <table class="table" style="color: black">
    <thead>
        <tr>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">No</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">NISN</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">Nama</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">Jenis</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">Terbayar</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">Kurang</th>
            <th style="text-align: center; vertical-align:ceter; font-weight:bold;">Total Tanggungan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $s)
            <tr>
                <td rowspan="2" style="text-align: center;vertical-align:center;">{{$loop->iteration}}</td>
                <td rowspan="2" style="text-align: left;vertical-align:center;">{{$s->nisn}}</td>
                <td rowspan="2" style="text-align: left;vertical-align:center;">{{$s->nama}}</td>
                <td>Sekarang</td>
                <td style="text-align:right;">{{terbayar($terbayar,$s->id_siswa,1)}}</td>
                <td style="text-align:right;">{{kurangAdm($administrasi,$s->id_siswa)}}</td>
                <td style="text-align:right;">{{kurangAdm($administrasi,$s->id_siswa) + terbayar($terbayar,$s->id_siswa,1)}}</td>
            </tr>
            <tr>
                <td>Sebelumnya</td>
                <td style="text-align:right;">{{terbayar($terbayar,$s->id_siswa,2)}}</td>
                <td style="text-align:right;">{{kurangTgg($tunggakan,$s->id_siswa)}}</td>
                <td style="text-align:right;">{{terbayar($terbayar,$s->id_siswa,2) + kurangTgg($tunggakan,$s->id_siswa)}}</td>
            </tr>
            @endforeach
    </tbody>
    
</table>
</body>
</html>