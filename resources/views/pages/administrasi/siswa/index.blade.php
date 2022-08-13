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
                    <th>NIS</th>
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
                data: 'nis',
                name: 'nis',
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

