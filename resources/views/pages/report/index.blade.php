@extends('app',['content'=>'dashboard'])

@section('content')
<?php use App\Traits\Helper; ?>
<section class="section">
    <div class="section-header">
        <div class="text-left">
            <h1>Report</h1>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <a href="{{url('export/siswa')}}">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Siswa
            </div>
          </div>
        </div>
        </a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <a href="{{url('export/siswa-administrasi')}}">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Administrasi Siswa
            </div>
          </div>
        </div>
        </a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <a href="{{url('export/pengeluaran')}}">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Pengeluaran
            </div>
          </div>
        </div>
        </a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <a href="{{url('export/pemasukan')}}">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Pemasukan
            </div>
          </div>
        </div>
        </a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Riwayat Pembayaran
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-dark">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Unduh</h4>
            </div>
            <div class="card-body">
              Rekapitulasi
            </div>
          </div>
        </div>
      </div>
      
    </div>
    
</section>

@endsection
