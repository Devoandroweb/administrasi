@php
    use App\Traits\Helper;
@endphp
<table>
    <thead>
        <tr>
            <th>#</th>
            <th style="font-weight: bold">TANGGAL</th>
            <th style="font-weight: bold">NISN</th>
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
            $nisn = "";
            $nama = "";
            $kelas = "";
            $tanggalConvert = "";
            
        @endphp
        @foreach($htransaksi as $val)
        @php $total = 0; $totalConvert = 0;@endphp
        @foreach(json_decode($val->{$tipe_tgg}) as $key)
        <tr>
            <td>
                @php

                    if($no != $i){
                        $i = $no;
                        if($tanggal != date("d-m-Y",strtotime($val->created_at))){
                            $tanggal = date("d-m-Y",strtotime($val->created_at));
                             if($val->siswa != null){
                                $nisn = $val->siswa->nisn;
                                $nama = $val->siswa->nama;
                                $kelas = $val->siswa->kelas->nama." ".$val->siswa->kelas->jurusan->nama;
                            }else{
                                $nisn = '-';
                            }
                            $tanggalConvert = Helper::convertDate($val->created_at,false,false);
                            $totalConvert = $val->totalSum(date('Y-m-d',strtotime($val->tanggal)));
                            echo $number;
                            $number++;
                            
                        }else{
                            if($val->siswa != null){
                                $nisn = $val->siswa->nisn;
                                $nama = $val->siswa->nama;
                                $kelas = $val->siswa->kelas->nama." ".$val->siswa->kelas->jurusan->nama;
                            }else{
                                $nisn = '-';
                            }
                            $tanggalConvert = "";
                            $nama = "";
                            $nisn = "";
                        }
                        
                    }else{
                        $nama = "";
                        $nisn = "";
                        $tanggalConvert = "";
                    }
                @endphp
            </td>
            <td>{{$tanggalConvert}}</td>
            <td style="text-align: left">{{$nisn}}</td>
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