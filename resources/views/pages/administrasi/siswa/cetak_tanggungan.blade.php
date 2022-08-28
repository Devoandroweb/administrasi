<?php

use App\Traits\Helper;

?>
<html>

<head>
    <title>Data Tanggungan</title>
</head>


<body style="font-family: 'monaco';">
    
    <div class="content">
        <div class="header" style="margin-bottom: 20px">
            <table>
                <tr>
                    <td width="25%" style="text-align: center"><img src="{{ asset('assets/img/logo_sekolah.png') }}" width="60%"></td>
                    <td style="text-align: center;">
                        <h1>SMA ISLAM AL-HIKMAH</h1>
                        <label><small>Jl. Raya Tanjungsari Kuwolu Bululawang Malang Jawa Timur</small></label>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="body">
            <h4 class="bank-r" style="margin-bottom: 2rem;text-align:center">BIAYA ADMINISTRASI SISWA</h4>
            <table width="100%">
                <tr>
                    <td style="">NISN</td>
                    <td style="width:2%">:</td>
                    <td style="width:30%">{{$siswa->nisn}}</td>
                    <td style="">Kelas</td>
                    <td style="width:2%">:</td>
                    <td style="">{{$siswa->kelas->nama." ".$siswa->kelas->jurusan->nama}}</td>
                </tr>
                <tr>
                    <td style="">Nama</td>
                    <td style="">:</td>
                    <td style="">{{$siswa->nama}}</td>
                    <td style="">Tanggal Unduh</td>
                    <td style="">:</td>
                    <td style="">{{Helper::convertDate(date("Y-m-d"),true,false)}}</td>
                </tr>
            </table>
            <hr style="display: block; height: 1px;
                border: 0; border-top: 1px solid #ccc;
                margin: 1em 0; padding: 0;">
            <table style="margin-top: 20px; width:100%">
                @php 
                    $headerGroup = ""; 
                    $yearAkademicNow = Session::get('tahun_awal')." - ". Session::get('tahun_akhir');
                    $no = 1;
                    // dd(count($biayaNow));
                @endphp
                <tr>
                    <td colspan="3" style="font-weight: bold; padding-top:20px;padding-bottom:10px;">Tahun Ajaran : {{$yearAkademicNow}}</td>
                </tr>
                @if(count($biayaNow) == 0)
                <tr>
                    <td colspan="3" style="padding-top:20px;padding-bottom:10px;text-align:center;">Tidak ada Tanggungan</td>
                </tr>
                @endif
                @foreach ($biayaNow as $item)
                <tr>
                    <td>{{$loop->iteration." ".$item->jenisAdministrasi->nama}}</td>
                    @if($item->nominal != 0)
                    <td style="text-align: right;width:5%;">Rp. </td>
                    <td style="text-align: right">{{number_format($item->nominal,2,".",",")}}</td>
                    @else
                    <td style="text-align: right"></td>
                    <td style="text-align: right; color:#47c363 ;">Lunas</td>
                    @endif
                </tr>
                @php @endphp
                @endforeach
                
                @foreach ($biayaBefore as $item)
                @if($headerGroup != $item->ajaran)
                @php $headerGroup = $item->ajaran; $no = 1;@endphp
                <tr>
                    <td colspan="2" style="font-weight: bold; padding-top:20px;padding-bottom:10px;">Tahun Ajaran : {{$headerGroup}}</td>
                </tr>
                @endif
                <tr>
                    <td style="width:70%;">{{$no." ".$item->nama_tunggakan}}</td>
                    @if($item->nominal != 0)
                    <td style="text-align: right;">Rp. </td>
                    <td style="text-align: right;width:25%;">{{number_format($item->nominal,2,".",",")}}</td>
                    @else
                    <td style="text-align: right"></td>
                    <td style="text-align: right; color:#47c363 ;">Lunas</td>
                    @endif
                </tr>
                @php $no++;@endphp
                @endforeach
            </table>
            <div style="color: #fc544b; margin-top:3rem;text-align:center;">
                <b>Perhatian !!</b> di mohon untuk segera melunasi pembayaran</span></i>
            </div>
        </div>

    </div>
    <script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/plugins/autoNumeric.js')}}"></script>
</body>


</html>