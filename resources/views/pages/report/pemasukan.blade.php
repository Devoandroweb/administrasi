@php
    use App\Traits\Helper;
@endphp
<table>
    <thead>
        <tr>
            <th>#</th>
            <th style="font-weight: bold">TANGGAL</th>
            <th style="font-weight: bold">NIS</th>
            <th style="font-weight: bold">NAMA SISWA</th>
            <th style="font-weight: bold">KELAS</th>
            <th style="font-weight: bold">DESKRIPSI</th>
            <th style="font-weight: bold">NOMINAL</th>
            <th style="font-weight: bold">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $number = 1;
            $i = 0;
            $tanggal = "";
            $nis = "";
            $nama = "";
            $kelas = "";
            $tanggalConvert = "";
            
        @endphp
        @foreach($pemasukan as $val)
        @php $total = 0; $totalConvert = 0;@endphp
        @foreach(json_decode($val->detail) as $key)

        <tr>
            <td>
                @php

                    if($no != $i){
                        $i = $no;
                        if($tanggal != date("d-m-Y",strtotime($val->created_at))){
                            $tanggal = date("d-m-Y",strtotime($val->created_at));
                            if($val->tipe_pemasukan == 1){
                                $nis = $val->siswa->nis;
                                $nama = $val->siswa->nama;
                                $kelas = $val->siswa->kelas->nama." ".$val->siswa->kelas->jurusan->nama;
                            }elseif($val->tipe_pemasukan == 2){
                                $nis = "-";
                                $nama = "-";
                                $kelas = "-";
                            }
                            $tanggalConvert = Helper::convertDate($val->created_at,false,false);
                            $totalConvert = $val->totalSum(date('Y-m-d',strtotime($val->created_at)),1);
                            echo $number;
                            $number++;
                            
                        }else{
                            if($val->tipe_pemasukan == 1){
                                $nis = $val->siswa->nis;
                                $nama = $val->siswa->nama;
                                $kelas = $val->siswa->kelas->nama." ".$val->siswa->kelas->jurusan->nama;
                            }elseif($val->tipe_pemasukan == 2){
                                $nis = "-";
                                $nama = "-";
                                $kelas = "-";
                            }
                            $tanggalConvert = "";
                        }
                        
                    }else{
                        $nama = "";
                        $nis = "";
                        $tanggalConvert = "";
                    }
                @endphp
            </td>
            <td>{{$tanggalConvert}}</td>
            <td style="text-align: left">{{$nis}}</td>
            <td>{{$nama}}</td>
            <td>{{$kelas}}</td>
            <td>{{$key->nama_biaya}}</td>
            <td style="text-align: right">{{number_format($key->nominal,2,".",",")}}</td>
            <td style="text-align: right">
                @php 
                    if($totalConvert != $total){
                        $total = $totalConvert;
                        echo number_format($totalConvert,2,".",",");
                    }
                @endphp
            </td>
        </tr>
        @endforeach
        @php $no++; @endphp
        @endforeach
    </tbody>
</table>