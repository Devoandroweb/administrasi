@php
    use App\Traits\Helper;
@endphp
<table>
    <thead>
        <tr>
            <th>#</th>
            <th style="font-weight: bold">TANGGAL</th>
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
            $tanggalConvert = "";
            
        @endphp
        @foreach($pengeluaran as $val)
        @php $total = 0; $totalConvert = 0;@endphp
        @foreach(json_decode($val->detail) as $key)

        <tr>
            <td>
                @php

                    if($no != $i){
                        $i = $no;
                        if($tanggal != date("d-m-Y",strtotime($val->created_at))){
                            $tanggal = date("d-m-Y",strtotime($val->created_at));
                            $tanggalConvert = Helper::convertDate($val->created_at,false,false);
                            $totalConvert = $val->totalSum(date('Y-m-d',strtotime($val->created_at)),2);
                            echo $number;
                            $number++;
                            
                        }else{
                            
                            $tanggalConvert = "";
                        }
                        
                    }else{
                        $tanggalConvert = "";
                    }
                @endphp
            </td>
            <td>{{$tanggalConvert}}</td>
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