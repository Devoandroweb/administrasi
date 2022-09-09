@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Administrasi Siswa</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('administrasi_siswa') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Biaya setiap Siswa</h4>
            <div class="card-header-action">
                <a href="{{url('export/siswa-administrasi')}}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel"></i> Export Administrasi Siswa
                </a>
            </div>
            <div class="card-header-action">
                
                <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="btn btn-warning filter dropdown-toggle" aria-expanded="false"><i class="fas fa-filter"></i> Filter : Semua</a>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a href="{{ url("datatable/administrasi") }}" data-text="Semua" class="dropdown-item sub-filter has-icon">Semua</a>
                    @foreach ($kelas as $item)
                    <a href="{{ url("datatable/administrasi?kelas=".$item->id_kelas) }}" data-text="{{$item->nama." ".$item->jurusan->nama}}" class="dropdown-item sub-filter has-icon">{{$item->nama." ".$item->jurusan->nama}}</a>
                    @endforeach
                    <a href="{{ url("datatable/administrasi?kelas=0") }}" data-text="Alumni" class="dropdown-item sub-filter has-icon">Alumni</a>

                </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th></th>
                    <th class="text-center">
                        #
                    </th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Biaya</th>
                    <th>Kelas</th>
                    <th></th>
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
// CUKUP UBAH VARIABLE BERIKUT

var _URL_DATATABLE = '{{ url("datatable/administrasi") }}';
var _TABLE = null;
// SESUAIKAN COLUMN DATATABLE
// SESUAIKAN FIELD EDIT MODAL
setDataTable();
function setDataTable() {
    _TABLE = $('#data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: _URL_DATATABLE,
        },
        rowReorder: {
            selector: 'td:nth-child(1)'
        },
        responsive: true,
        columns: [
            {
                className: 'dt-control dtr-control',
                data:null,
                width: '4%',
                orderable: false,
                searchable: false,
                defaultContent: ''},
            {
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '4%',
                className: 'text-center'
            },{
                data: 'nisn',
                name: 'nisn',
                width: '15%',

            },{
                data: 'nama',
                name: 'nama',
            },{
                data: 'biaya',
                name: 'biaya',
                visible: false,
            },{
                data: 'kelas',
                name: 'kelas',
            },{
                data: 'tunggakan',
                name: null,
            }
            // ,{
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // }
        ]
        });
    }
    //DOM
    $(".sub-filter").click(function (e) { 
        e.preventDefault();
        _URL_DATATABLE = $(this).attr('href');
        _TABLE.ajax.url(_URL_DATATABLE).load();
        // setDataTable();
        $(".filter").text("Filter : "+$(this).data('text').toUpperCase());
    });
    
    // Add event listener for opening and closing details
    function format(value) {
        // console.log();
            return value.biaya;
        };
    $('#data tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = _TABLE.row(tr);
        
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('dt-hasChild shown');
        } else {
            // Open this row
            // console.log(row.data()[4]);
            row.child(format(row.data())).show();
            tr.addClass('dt-hasChild shown');
        }
    });

</script>

<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

