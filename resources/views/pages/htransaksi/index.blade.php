@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Riwayat Transaksi</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('htransaksi') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
                <p>Data Riwayat Pembayaran siswa</p>   
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Tanggungan Sekarang</th>
                    <th>Tanggungan Sebelumnya</th>
                    <th>Terbayar</th>
                    <th>Total</th>
                    <th>Penyetor</th>
                    <th>Penerima</th>
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
var _URL_DATATABLE = '{{ url("datatable/htransaksi") }}';
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
        columns: [{
                className: 'dt-control dtr-control',
                data:null,
                width: '4%',
                orderable: false,
                searchable: false,
                defaultContent: ''},
            {
                data: 'kode',
                name: 'kode',
            },{
                data: 'tanggal',
                name: 'tanggal',
            },{
                data: 'biaya_convert',
                name: 'biaya_convert',
                orderable: false,
                visible: false,
                searchable: false,
            },{
                data: 'tunggakan_convert',
                name: 'tunggakan_convert',
                visible: false,
                orderable: false,
                searchable: false,
            },{
                data: 'terbayar',
                name: 'terbayar',
            },{
                data: 'total',
                name: 'total',
            },{
                data: 'penyetor',
                name: 'id_siswa',
            },{
                data: 'penerima',
                name: 'created_by',
            },{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });
    }
    function format(value) {
        console.log(value);
            var html = "<div class='d-flex w-100'>";
                html += "<div class='w-50'>"
                html += value.biaya_convert
                html += "</div>";
                html += "<div class='w-50'>";
                html += value.tunggakan_convert;
                html += "</div>";
            return html;
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

@endpush

