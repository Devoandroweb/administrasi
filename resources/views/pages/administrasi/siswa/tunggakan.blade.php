@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Detail Tunggakan</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('administrasi_siswa_tunggakan') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Biaya tunggakan dengan Nama : <b class="text-success">{{$siswa->nama}}</b> <i class="fas fa-angle-right"></i> Kelas : <b class="text-danger">{{$siswa->kelas->nama." ".$siswa->kelas->jurusan->nama}}</b> </h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center" width="5%">
                        #
                    </th>
                    <th>Nama Biaya</th>
                    <th>Nominal</th>
                    <th>Tahun AJaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->nama_tunggakan}}</td>
                            <td>{!!($item->nominal == 0) ? '<span class="text-success">Lunas</span>' : Helper::ribuan($item->nominal)!!}</td>
                            <td>{{$item->ajaran}}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            </div>
        </div>
</section>

@endsection
@push('js')
<script>
$("#data").DataTable();
</script>
@endpush
