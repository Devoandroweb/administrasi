@extends('app',['content'=>'dashboard'])

@section('content')
<?php use App\Traits\Helper; ?>
<section class="section">
    <div class="section-header">
        <div class="text-left">
            <h1>Adminisrasi Siswa</h1>
            <p class="mb-0"><i>Di bawah ini adalah biaya siswa yang belum di bayar maupun yang lunas</i></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
            <div class="card-header">
                <h4>Daftar Biaya</h4>
                <div class="card-header-action">
                
                </div>
            </div>
            <div class="card-body">
                <div class="summary">
                <div class="summary-info">
                    <h5>Total Tanggungan</h5>
                    <h4 class="text-warning">Rp. {{number_format($totalTunggakan,2,".",",")}}</h4>
                    <div class="text-muted"><span class="text-success">Lunas</span> {{$totalLunas}} Biaya dan <span class="text-danger">Belum Lunas</span> {{$totalBelumLunas}} Biaya</div>
                    <div class="d-block mt-2">
                    </div>
                </div>
                <div class="summary-item">
                    <p><i><span class="text-danger"><b>Perhatian !!</b> di mohon untuk segera melunasi pembayaran</span></i></p>
                    <hr>
                    <h6>Item List <span class="text-muted">({{$biayaNow->count()+$biayaBefore->count()}} Items)</span></h6>
                    <ul class="list-unstyled list-unstyled-border">
                    @foreach($biayaNow as $key)
                        <li class="media">
                            <div class="media-body">
                            @if($key->nominal != 0)
                            <div class="media-right">Rp. {{number_format($key->nominal,2,".",",")}}</div>
                            @else
                            <div class="media-right text-success">Lunas</div>
                            @endif
                            <div class="media-title"><a href="#">{{$key->jenisAdministrasi->nama}}</a></div>
                            <div class="text-muted text-small"><span class="text-primary">Tahun Ajaran</span> <div class="bullet"></div> {{Session::get('tahun_awal')}} - {{Session::get('tahun_akhir')}}</div>
                            </div>
                        </li>
                    @endforeach
                    @foreach($biayaBefore as $key)
                        <li class="media">
                            <div class="media-body">
                            @if($key->nominal != 0)
                            <div class="media-right">Rp. {{number_format($key->nominal,2,".",",")}}</div>
                            @else
                            <div class="media-right text-success">Lunas</div>
                            @endif
                            <div class="media-title"><a href="#">{{$key->nama_tunggakan}}</a></div>
                            <div class="text-muted text-small"><span class="text-danger">Tahun Ajaran</span> <div class="bullet"></div> {{$key->ajaran}}</div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</section>

@endsection
