<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Rekap Sebelumnya</title>
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
        use App\Models\MTunggakan;
        use App\Models\MRekapTunggakan;
        use App\Traits\Helper;
        $jenisTgg = MTunggakan::groupBy('nama_tunggakan')->get();
        $tggTA = MTunggakan::groupBy('ajaran')->get();
        function getSumNominalTunggakan($namaTunggakan,$TA)
        {
            $total = 0;
            $tgg = MTunggakan::all();
            foreach ($tgg as $key) {
                if($key->nama_tunggakan == $namaTunggakan && $key->ajaran == $TA){
                    $total = $total + $key->nominal;
                }
            }
            return $total;
        }
        function getRekapTunggakanTotal($nama_tunggakan,$TA)
        {
            $mRekapTunggakan = MRekapTunggakan::where('nama_tunggakan',$nama_tunggakan)->where('ajaran',$TA)->first();
            return $mRekapTunggakan->total;
        }
        
    ?>
    <table>
        <tr>
            <td style="text-align: center;">
                <center>
                    <img src="{{public_path('assets/img/logo_sekolah_for_excel.png')}}" style="margin-left:200px;">
                </center>
            </td>
            <td colspan="{{$jenisTgg->count()+2}}" style="vertical-align:center;text-align:center;font-weight:bold;">
                <h3 style="font-size: 15pt;font-weight:bold">SMA ISLAM AL-HIKMAH</h3>
                <br>
                <label><small>Jl. Raya Tanjungsari Kuwolu Bululawang Malang Jawa Timur</small></label>
            </td>
        </tr>
        <tr>
            <td colspan="{{$jenisTgg->count()+3}}" style="border-bottom: 1px solid black"></td>
        </tr>
        <tr>
            <td colspan="{{$jenisTgg->count()+3}}" style="font-weight: bold;text-align:center;">Tanggungan Sebelumnya</td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    <table>
        <thead>
        <tr style="">
            <th  rowspan="2" style="vertical-align: center"><b>Tahun Ajaran</b> </th>
            <th  rowspan="2" style="vertical-align: center;text-align:center"><b>Status</b> </th>
            <th  colspan="{{$jenisTgg->count()}}" style="text-align:center"><b>Jenis Tanggungan</b></th>
            <th style="width:100px;vertical-align: center;text-align:center" rowspan="2"><b>Jumlah</b></th>
        </tr>
        <tr style="">
            @foreach ($jenisTgg as $item)
                <th style="text-align: center;font-weight: bold" colspan="">{{$item->nama_tunggakan}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @php
                $totalInAjaranTanggungan = [];
                $totalInAjaranKurang = [];
                $totalInAjaranTerbayar = [];
                foreach ($jenisTgg as $key) {
                    $totalInAjaranTanggungan[strtolower($key->nama_tunggakan)] = 0; 
                    $totalInAjaranTerbayar[strtolower($key->nama_tunggakan)] = 0; 
                    $totalInAjaranKurang[strtolower($key->nama_tunggakan)] = 0; 
                }
                
            @endphp
            @foreach ($tggTA as $ta)
                {{-- Tanggungan --}}
                <tr>
                    <td rowspan="3" style="vertical-align: center">{{$ta->ajaran}}</td>
                    <td>Tanggungan</td>
                    @php
                        $totalTanggungan = 0;
                    @endphp 
                    @foreach ($jenisTgg as $jenis)
                        @php
                            $nominalTanggungan = getSumNominalTunggakan($jenis->nama_tunggakan,$ta->ajaran) + getRekapTunggakanTotal($jenis->nama_tunggakan,$ta->ajaran);
                            $totalTanggungan = $totalTanggungan + $nominalTanggungan;
                            $totalInAjaranTanggungan[strtolower($jenis->nama_tunggakan)] = $totalInAjaranTanggungan[strtolower($jenis->nama_tunggakan)] + $nominalTanggungan;
                             
                        @endphp
                        <td style="text-align: right">{{$nominalTanggungan}}</td>
                    @endforeach
                    <td style="text-align: right;">{{$totalTanggungan}}</td>
                </tr>
                {{-- yg sudah di bayar --}}
                <tr>
                    @php
                        $totalTerbayar = 0;
                    @endphp
                    <td>Terbayar</td>
                     @foreach ($jenisTgg as $jenis)
                        @php
                            $nominalTerbayar = getRekapTunggakanTotal($jenis->nama_tunggakan,$ta->ajaran);
                            $totalTerbayar = $totalTerbayar + $nominalTerbayar;
                            $totalInAjaranTerbayar[strtolower($jenis->nama_tunggakan)] = $totalInAjaranTerbayar[strtolower($jenis->nama_tunggakan)] + $nominalTerbayar;
                        @endphp
                        <td style="text-align: right">{{
                            $nominalTerbayar;
                        }}</td>
                    @endforeach
                    <td style="text-align: right;">{{$totalTerbayar}}</td>
                </tr>
                {{-- Kurang --}}
                <tr>
                    @php
                        $totalKurang = 0;
                    @endphp
                    <td>Kurang</td>
                    @foreach ($jenisTgg as $jenis)
                        @php
                            $nominalKurang = getSumNominalTunggakan($jenis->nama_tunggakan,$ta->ajaran);
                            $totalKurang = $totalKurang + $nominalKurang;
                            $totalInAjaranKurang[strtolower($jenis->nama_tunggakan)] = $totalInAjaranKurang[strtolower($jenis->nama_tunggakan)] + $nominalKurang;
                        @endphp
                        <td style="text-align: right">{{
                                $nominalKurang
                            }}</td>
                    @endforeach
                    <td style="text-align: right;">{{$totalKurang}}</td>
                </tr>
                
            @endforeach
            @php
            // dd($totalInAjaranTerbayar);
                $jumlahInajaranTanggungan = 0;
                $jumlahInajaranTerbayar = 0;
                $jumlahInajaranKurang = 0;

            @endphp
            <tr style="font-weight: bold;">
                <td rowspan="3" style="vertical-align: center"><b>Total</b></td>
                <td><b>Tanggungan</b></td>
                @foreach ($jenisTgg as $jenis)
                @php
                    $jumlah = $totalInAjaranTanggungan[strtolower($jenis->nama_tunggakan)];
                    $jumlahInajaranTanggungan = $jumlahInajaranTanggungan + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;">{{$jumlahInajaranTanggungan}}</td>
            </tr>
            
            <tr>
                <td><b>Terbayar</b></td>
                @foreach ($jenisTgg as $jenis)
                @php
                    $jumlah = $totalInAjaranTerbayar[strtolower($jenis->nama_tunggakan)];
                    $jumlahInajaranTerbayar = $jumlahInajaranTerbayar + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;">{{$jumlahInajaranTerbayar}}</td>

            </tr>
            <tr>
                <td><b>Kurang</b></td>
                @foreach ($jenisTgg as $jenis)
                @php
                    $jumlah = $totalInAjaranKurang[strtolower($jenis->nama_tunggakan)];
                    $jumlahInajaranKurang = $jumlahInajaranKurang + $jumlah;
                @endphp
                    <td style="text-align: right;font-weight: bold;">{{$jumlah}}</td>
                @endforeach
                <td style="text-align: right;font-weight: bold;">{{$jumlahInajaranKurang}}</td>
            </tr>
        </tbody>
    </table>


</body>
</html>