@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Cicilan Siswa</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('administrasi_siswa_cicilan') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Cicilan Pembayaran dengan Nama : <b class="text-success">{{$siswa->nama}}</b> <i class="fas fa-angle-right"></i> Kelas : <b class="text-danger">{{$siswa->namaKelas()}}</b> </h4>
            </div>
        </div>
        
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-ta-now" role="tab" aria-controls="tab-ta-now" aria-selected="true">TA {{Session::get('tahun_awal')."/".Session::get('tahun_akhir')}}</a>
            </li>
            @foreach ($ajaran as $aj)
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#tab-ta-{{$aj->id}}" role="tab" aria-controls="tab-ta-{{$aj->id}}" aria-selected="false">TA {{$aj->tahun_awal."/".$aj->tahun_akhir}}</a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-ta-now" role="tabpanel" aria-labelledby="tab-ta-now">
                <div class="row">
                    @foreach ($administrasi as $item)
                    
                    @if($item->tipe === 1)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">{{$item->nama}}</h4>
                                <div class="card-header-action">
                                    <a data-collapse="#adm-tab-{{$loop->iteration}}" class="btn btn-icon btn-danger" href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="adm-tab-{{$loop->iteration}}">
                                <div class="card-body">
                                    @if($item->deskripsi != null)
                                    <table class="w-100">
                                        {{-- <td>{{$item->deskripsi}}</td> --}}
                                        @php
                                            $desc = json_decode($item->deskripsi); 
                                        @endphp
                                        @foreach ($desc as $des)    
                                        <tr>
                                            <td>Cicilan {{$loop->iteration}}</td>
                                            <td class="text-right">{{Helper::ribuan($des)}}</td>
                                        </tr>
                                        @endforeach
                                        
                                    </table>
                                    @else
                                    <div class="text-danger w-100 text-center">
                                        Tidak ada Pembayaran
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @foreach ($ajaran as $aj)
            <div class="tab-pane fade" id="tab-ta-{{$aj->id}}" role="tabpanel" aria-labelledby="tab-ta-{{$aj->id}}">
                <div class="row">
                @foreach ($tunggakan as $tgg)
                    @if($aj->tahun_awal." - ".$aj->tahun_akhir == $tgg->ajaran)
                        @if($tgg->cicilan->tipe == 2)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="text-dark">{{$tgg->nama_tunggakan}}</h4>
                                        <div class="card-header-action">
                                            <a data-collapse="#tgg-tab-{{$loop->iteration}}" class="btn btn-icon btn-danger" href="#"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="collapse" id="tgg-tab-{{$loop->iteration}}">
                                        <div class="card-body">
                                            @if($tgg->cicilan->deskripsi != null)
                                            <table class="w-100">
                                                {{-- <td>{{$tgg->cicilan->deskripsi}}</td> --}}
                                                @php
                                                    $desc = json_decode($tgg->cicilan->deskripsi); 
                                                @endphp
                                                @foreach ($desc as $des)    
                                                <tr>
                                                    <td>Cicilan {{$loop->iteration}}</td>
                                                    <td class="text-right">{{Helper::ribuan($des)}}</td>
                                                </tr>
                                                @endforeach
                                                
                                            </table>
                                            @else
                                            <div class="text-danger w-100 text-center">
                                                Tidak ada Pembayaran
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
@push('js')
<script>

</script>
@endpush
