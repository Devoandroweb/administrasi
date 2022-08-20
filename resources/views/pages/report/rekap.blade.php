<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Rekap</title>
</head>
<style>
    table{
        border-collapse: collapse;
        border: 1px solid black;
    }
    table th,td{
        padding: 0.5rem;
        border: 1px solid black;
    }

</style>
<body>
    <?php
        use App\Models\MJenisAdministrasi;
        use App\Models\MKelas;
        use App\Models\MRekap;
        use App\Traits\Helper;
        $mJenisAdm = MJenisAdministrasi::all();
        $mKelas = MKelas::with('jurusan')->orderBy('no_urut','asc')->get();
        function cariRekap($_idJenisAdm,$_idKelas)
        {
            $mRekap = MRekap::all();
            foreach ($mRekap as $key) {
                if($key->id_jenis_administrasi == $_idJenisAdm && $key->id_kelas == $_idKelas){
                    return $key->total;
                }
            }
            return 0;
        }
        function cariAdmTotal($id_jenis_adm,$id_kelas)
        {
            $data = DB::selectOne("SELECT m_siswa.id_kelas, SUM(administrasi.nominal) as nominal_adm FROM administrasi 
                        INNER JOIN m_siswa ON m_siswa.id_siswa = administrasi.id_siswa 
                        INNER JOIN m_kelas ON m_siswa.id_kelas = m_kelas.id_kelas 
                        WHERE id_jenis_administrasi = {$id_jenis_adm} AND m_siswa.id_kelas = {$id_kelas} GROUP BY m_siswa.id_kelas");
            if($data == null){
                return 0;
            }
            return $data->nominal_adm;
        }
    ?>
    <table>
        <tr>
            <td style="text-align: center;">
                <center>
                    <img src="{{public_path('assets/img/logo_sekolah_for_excel.png')}}" style="margin-left:200px;">
                </center>
            </td>
            <td colspan="{{$mKelas->count()+2}}" style="vertical-align:center;text-align:center;font-weight:bold;">
                <h3 style="font-size: 15pt;font-weight:bold">SMA ISLAM AL-HIKMAH</h3>
                <br>
                <label><small>Jl. Raya Tanjungsari Kuwolu Bululawang Malang Jawa Timur</small></label>
            </td>
        </tr>
        <tr>
            <td colspan="{{$mKelas->count()+3}}" style="border-bottom: 1px solid black"></td>
        </tr>
        <tr>
            <td colspan="{{$mKelas->count()+3}}" style="font-weight: bold;text-align:center;">Tanggungan Tahun Ajaran {{Session::get('tahun_awal')."/".Session::get('tahun_akhir')}}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    <table>
        <thead>
        <tr style="">
            <th  rowspan="2" style="width:150px;vertical-align: center;border: 1px solid black;"><b>Nama Pembayaran</b> </th>
            <th  rowspan="2" style="vertical-align: center;text-align:center;border: 1px solid black;"><b>Status</b> </th>
            <th  colspan="{{$mKelas->count()}}" style="text-align:center;border: 1px solid black;"><b>Kelas</b></th>
            <th style="width:100px;vertical-align: center;text-align:center;border: 1px solid black;" rowspan="2"><b>Jumlah</b></th>
        </tr>
        <tr style="">
            @foreach ($mKelas as $item)
                <th style="width:90px;font-weight:bold;text-align:center;border: 1px solid black;">{{$item->nama." ".$item->jurusan->nama}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @php
                $totalInKelasTanggungan = [];
                $totalInKelasKurang = [];
                $totalInKelasTerbayar = [];
                foreach ($mKelas as $key) {
                    $totalInKelasTanggungan[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                    $totalInKelasKurang[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                    $totalInKelasTerbayar[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                }
                
            @endphp
            @foreach ($mJenisAdm as $jenisAdm)
                {{-- Tanggungan --}}
                <tr>
                    <td rowspan="3" style="vertical-align: center;border: 1px solid black;">{{$jenisAdm->nama}}</td>
                    <td style="border: 1px solid black;">Tanggungan</td>
                    @php
                        $totalTanggungan = 0;
                    @endphp 
                    @foreach ($mKelas as $item)
                        @php
                            $nominalTanggungan = cariAdmTotal($jenisAdm->id,$item->id_kelas) + cariRekap($jenisAdm->id,$item->id_kelas);
                            $totalTanggungan = $totalTanggungan + $nominalTanggungan;
                            $totalInKelasTanggungan[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasTanggungan[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalTanggungan;
                             
                        @endphp
                        <td style="text-align: right;border: 1px solid black;">{{$nominalTanggungan}}</td>
                    @endforeach
                    <td style="text-align: right;border: 1px solid black;">{{$totalTanggungan}}</td>
                </tr>
                {{-- yg sudah di bayar --}}
                <tr>
                    @php
                        $totalTerbayar = 0;
                    @endphp
                    <td style="border: 1px solid black;">Terbayar</td>
                     @foreach ($mKelas as $item)
                        @php
                            $nominalTerbayar = cariRekap($jenisAdm->id,$item->id_kelas);
                            $totalTerbayar = $totalTerbayar + $nominalTerbayar;
                            $totalInKelasTerbayar[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasTerbayar[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalTerbayar;
                        @endphp
                        <td style="text-align: right;border: 1px solid black;">{{
                            $nominalTerbayar;
                        }}</td>
                    @endforeach
                    <td style="text-align: right;border: 1px solid black;">{{$totalTerbayar}}</td>
                </tr>
                {{-- Kurang --}}
                <tr>
                    @php
                        $totalKurang = 0;
                    @endphp
                    <td style="border: 1px solid black;">Kurang</td>
                    @foreach ($mKelas as $item)
                        @php
                            $nominalKurang = cariAdmTotal($jenisAdm->id,$item->id_kelas);
                            $totalKurang = $totalKurang + $nominalKurang;
                            $totalInKelasKurang[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasKurang[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalKurang;
                        @endphp
                        <td style="text-align: right;border: 1px solid black;">{{
                                $nominalKurang
                            }}</td>
                    @endforeach
                    <td style="text-align: right;border: 1px solid black;">{{$totalKurang}}</td>
                </tr>
                
            @endforeach
            @php
                $jumlahInKelasTanggungan = 0;
                $jumlahInKelasKurang = 0;
                $jumlahInKelasTerbayar = 0;

            @endphp
            <tr style="font-weight: bold;">
                <td rowspan="3" style="vertical-align: center;border: 1px solid black;"><b>Total</b></td>
                <td style="border: 1px solid black;"><b>Tanggungan</b></td>
                @foreach ($mKelas as $kelas)
                @php
                    $jumlah = $totalInKelasTanggungan[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                    $jumlahInKelasTanggungan = $jumlahInKelasTanggungan + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlahInKelasTanggungan}}</td>
            </tr>
            
            <tr>
                <td style="border: 1px solid black;"><b>Terbayar</b></td>
                @foreach ($mKelas as $kelas)
                @php
                    $jumlah = $totalInKelasTerbayar[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                    $jumlahInKelasTerbayar = $jumlahInKelasTerbayar + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlahInKelasTerbayar}}</td>

            </tr>
            <tr>
                <td style="border: 1px solid black;"><b>Kurang</b></td>
                @foreach ($mKelas as $kelas)
                @php
                    $jumlah = $totalInKelasKurang[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                    $jumlahInKelasKurang = $jumlahInKelasKurang + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{$jumlahInKelasKurang}}</td>

            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <td></td>
            <td colspan="2">Mengetahui,</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Malang, 20 Maret 2022</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Kepala Sekolah</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Bendahara</td>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td></td>
            <td colspan="2">Kepala Sekolah</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Bendahara</td>
        </tr>
    </table>
</body>
</html>