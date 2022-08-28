@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Pegeluaran dan Pemasukan</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('pendanaan') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Pemasukan dan pengeluaran</h4>
            <div class="card-header-action dropdown ">
                <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle mr-2" aria-expanded="false"><i class="fas fa-file-excel"></i> Pilih Export</a>
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-126px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <li class="dropdown-title">Pilih Export</li>
                    <li><a href="{{url('export/pemasukan')}}" class="dropdown-item">Pemasukan</a></li>
                    <li><a href="{{url('export/pengeluaran')}}" class="dropdown-item">Pengeluaran</a></li>
                </ul>
            </div>
            @if(auth()->guard('web')->user()->role != 3)
            <div class="card-header-action mr-2">
                <a href="#" class="btn btn-danger " id="btn-add-data-peng">
                    <i class="fas fa-plus-circle"></i> Tambah Pengeluaran
                </a>
            </div>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary " id="btn-add-data-pem">
                <i class="fas fa-plus-circle"></i> Tambah Pemasukan
                </a>
            </div>
            @endif
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
                    <th>Detail</th>
                    <th>Total</th>
                    <th></th>
                    <th>Saldo</th>
                    <th>Tanggal</th>
                    {{-- <th>Action</th> --}}
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
<script type="text/javascript" src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>
<script>
// CUKUP UBAH VARIABLE BERIKUT
var _SALDO = "{{$saldo}}";
var _URL_INSERT_PEMASUKAN = '{{url("pemasukan/save")}}';
var _URL_INSERT_PENGELUARAN = '{{url("pengeluaran/save")}}';
var _URL_DATATABLE = '{{ url("datatable/pendanaan") }}';
var _TABLE = null;
// SESUAIKAN COLUMN DATATABLE
// SESUAIKAN FIELD EDIT MODAL
setDataTable();
// setNumeric();
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
                data: 'nis_convert',
                name: 'nisn',
                orderable: false,
                searchable: false,
                width: '15%',

            },{
                data: 'nama',
                name: 'nama',
            },{
                data: 'detail',
                name: 'detail',
                visible: false,
            },{
                data: 'total',
                name: 'total',
            },{
                data: 'status',
                name: null,
                searchable: false,
                orderable: false,
            },{
                data: 'saldo',
                name: 'saldo',
            },{
                data: 'created_at',
                name: 'created_at',
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
    $('#btn-add-data-pem').fireModal({
        title: "Tambah Pemasukan",
        body: '<?= Helper::includeAsJsString("pages.administrasi.pendanaan.form-pemasukan") ?>',
        buttons: [
            {
            text: '<i class="fas fa-plus-circle"></i> ',
            class: 'btn btn-success',
            handler: function(current_modal) {
                var html = '<?= Helper::includeAsJsString("pages.administrasi.pendanaan.input-pemasukan") ?>'
                current_modal.find('table').append(html);
                setNumeric();
            }
        },
        {
                submit: false,
                class: 'btn btn-primary',
                id: 'btn-submit',
                text: 'Simpan',
                handler: function(current_modal) {
                    saveForm($('#form-data-pem'),_URL_INSERT_PEMASUKAN,current_modal,1);
                }
        },
        {
            text: 'Close',
            class: 'btn btn-secondary',
            handler: function(current_modal) {
                $.destroyModal(current_modal);
                
            }
        }]
    });
    $('#btn-add-data-peng').fireModal({
        title: "Tambah Pengeluaran",
        body: '<?= Helper::includeAsJsString("pages.administrasi.pendanaan.form-pengeluaran") ?>',
        buttons: [
            {
            text: '<i class="fas fa-plus-circle"></i> ',
            class: 'btn btn-success',
            handler: function(current_modal) {
                var html = '<?= Helper::includeAsJsString("pages.administrasi.pendanaan.input-pengeluaran") ?>'
                current_modal.find('table').append(html);
                setNumeric();
            }
        },
        {
                submit: false,
                class: 'btn btn-primary',
                id: 'btn-submit',
                text: 'Simpan',
                handler: function(current_modal) {
                    // saveForm($('#form-data-peng'),_URL_INSERT_PENGELUARAN,current_modal,1);
                    cekSaldo();
                }
        },
        {
            text: 'Close',
            class: 'btn btn-secondary',
            handler: function(current_modal) {
                $.destroyModal(current_modal);
                
            }
        }]
    });
    $('#btn-add-data-pem').click(function(){
        removeInput();
        clearInput($('#form-data-pem'));
        setNumeric();
    });
    $('#btn-add-data-peng').click(function(){
        clearInput($('#form-data-peng'));
        removeInput();
        setNumeric();
    });
    // Add event listener for opening and closing details
    function format(value) {
        // console.log();
            return value.detail;
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
    $(document).on('click','.remove-input',function (e) { 
        e.preventDefault();
        $(this).closest('tr').remove();
    });
    function removeInput(){
        $(".add-input").remove();
    }
    function cekSaldo(){
        var totalInput = 0;
        $.each($(".nominal-peng"), function (indexInArray, valueOfElement) { 
             console.log(valueOfElement);
        });
    }
</script>

<script type="text/javascript" src="{{asset('assets/js/save.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

