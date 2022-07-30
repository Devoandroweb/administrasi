@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Data Pegawai</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('pegawai') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Pegawai untuk mengelola Human Resource</h4>
            <div class="card-header-action">
                <a href="{{$url}}" class="btn btn-primary" id="btn-add-data">
                Tambah Pegawai
                </a>
            </div>
            </div>
            <div class="card-body">
            @if(session('msg'))
                <div class="alert alert-danger">{{session('msg')}}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                </table>
            </div>
            </div>
        </div>
</section>

@endsection
@push('js')


<script>
    setDataTable();
    function setDataTable() {
        $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("datatable/pegawai") }}',
            },
            rowReorder: {
                selector: 'td:nth-child(1)'
            },
            responsive: true,
            columns: [{
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '4%',
                    className: 'text-center'
                },{
                    data: 'nip',
                    name: 'nip',
                },{
                    data: 'nama',
                    name: 'nama',
                },{
                    data: 'jk',
                    name: 'jk',
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }
</script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>
@endpush

