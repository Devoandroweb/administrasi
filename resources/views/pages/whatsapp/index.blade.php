@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Whatsapp Gateway</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('whatsapp') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Masukkan Chat Whatsapp ini akan di kirimkan ke Nomor Whatsapp tujuan </h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                Tambah Chat
                </a>
            </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>No Telepon</th>
                    <th>Pesan</th>
                    <th>Tipe</th>
                    <th>Status</th>
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
<script src="{{asset('vendor')}}/cleave.js/cleave.min.js"></script>
<script src="{{asset('vendor')}}/cleave.js/addons/cleave-phone.id.js"></script>
<script>
// CUKUP UBAH VARIABLE BERIKUT
var _STATUS_SUBMIT = 0;
var _TITLE_MODAL_ADD = "Tambah Whatsapp Chat";
var _ID_UPDATE = "";
var _URL_INSERT = '{{route("whatsapp.store")}}';
var _URL_UPDATE = '{{url("whatsapp")}}/';
var _URL_DATATABLE = '{{ url("datatable/whatsapp") }}';
// SESUAIKAN COLUMN DATATABLE
// SESUAIKAN FIELD EDIT MODAL
setDataTable();
function setDataTable() {
    $('#data').DataTable({
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
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '4%',
                className: 'text-center'
            },{
                data: 'no_telp_convert',
                name: 'no_telp',
            },{
                data: 'pesan_convert',
                name: 'pesan',
            },{
                data: 'tipe_convert',
                name: 'tipe',
                searchable: false,
            },{
                data: 'status_convert',
                name: 'status',
                searchable: false,
            },{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
            ]
        });
    }
$(document).on('click','#btn-add-data',function(e){
    _STATUS_SUBMIT = 1;
    clearInput("#form-data");
    $("#fire-modal-1").find(".modal-title").text(_TITLE_MODAL_ADD);
});

// open modal
$('#btn-add-data').fireModal({
    title: _TITLE_MODAL_ADD,
    body: '<?= Helper::includeAsJsString("pages.whatsapp.form") ?>',
    buttons: [
    {
            submit: false,
            class: 'btn btn-primary btn-sending',
            id: 'btn-submit',
            text: 'Simpan',
            handler: function(current_modal) {
                if(_STATUS_SUBMIT == 1){ // new
                    
                    var result = saveForm(
                        $('#form-data'),
                        _URL_INSERT,
                        current_modal,
                        1,
                        "POST",
                        ['siswa']
                        );
                }
            }
    },
    {
        text: 'Close',
        class: 'btn btn-secondary',
        handler: function(current_modal) {
            $.destroyModal(current_modal);
            
        }
    }
    ]
});
var cleavePN = new Cleave('.phone-number', {
        phone: true,
        phoneRegionCode: 'ID'
    });
$(".siswa-select").select2({ dropdownParent: "#fire-modal-1" });
$('.siswa-select').on('select2:select', function (e) {
    var data = e.params.data;
    var notelp = data.element.attributes['data-notelp'].value;
    $("#form-data").find('input[name=no_telp]').val(notelp);
});
$(document).on('click','#btn-add-data',function(e){

    clearInput("#form-data");

});
// submit data

</script>
<script type="text/javascript" src="{{asset('assets/js/save.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

