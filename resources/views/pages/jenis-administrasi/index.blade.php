@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Jenis Administrasi</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('jenis_administrasi') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Masukkan Jenis Administrasi sesuai Lembaga anda</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                Tambah Jenis Administrasi
                </a>
            </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>Nama Administrasi</th>
                    <th>Biaya</th>
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
<script type="text/javascript" src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>
<script>
// CUKUP UBAH VARIABLE BERIKUT
var _STATUS_SUBMIT = 0;
var _TITLE_MODAL_ADD = "Tambah Jenis Administrasi";
var _TITLE_MODAL_UPDATE = "Ubah Jenis Administrasi";
var _ID_UPDATE = "";
var _URL_INSERT = '{{route("jenis-administrasi.store")}}';
var _URL_UPDATE = '{{url("jenis-administrasi")}}/';
var _URL_DATATABLE = '{{ url("datatable/jenis-administrasi") }}';
// SESUAIKAN COLUMN DATATABLE
// SESUAIKAN FIELD EDIT MODAL
setDataTable();
function setDataTable() {
    $('table').DataTable({
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
                data: 'nama',
                name: 'nama',
            },{
                data: 'biaya',
                name: 'biaya',
            },{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });
    }
$(document).on('click','#btn-add-data',function(e){
    _STATUS_SUBMIT = 1;
    clearInput("#form-data");
    $("#fire-modal-1").find(".modal-title").text(_TITLE_MODAL_ADD);
});
$(document).on('click','.edit',function(e){
    var modal = $("#fire-modal-1");
    clearInput("#form-data");
    e.preventDefault();
    $.ajax({
        type: "get",
        url: $(this).attr("href"),
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                _STATUS_SUBMIT = 2;
                modal.find(".modal-title").text(_TITLE_MODAL_UPDATE);
                _ID_UPDATE = response.data.key;
                modal.find("input[name=nama]").val(response.data.nama);
                toRupiah(modal.find("input[name=biaya]"),response.data.biaya);
                modal.modal("show");
            }
        }
    });
});


// open modal
$('#btn-add-data').fireModal({
    title: _TITLE_MODAL_ADD,
    body: '<?= Helper::includeAsJsString("pages.jenis-administrasi.form") ?>',
    buttons: [
    {
            submit: false,
            class: 'btn btn-primary',
            id: 'btn-submit',
            text: 'Simpan',
            handler: function(current_modal) {
                
                if(_STATUS_SUBMIT == 1){ // new
                    saveForm(
                        $('#form-data'),
                        _URL_INSERT,
                        current_modal,
                        1
                        );
                }else if(_STATUS_SUBMIT == 2){ // update
                    var afterSave = saveForm(
                        $('#form-data'),
                        _URL_UPDATE+_ID_UPDATE,
                        current_modal,
                        2,
                        'PUT'
                        );
                    if(afterSave){
                        _ID_UPDATE = 0;
                    }
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

// submit data
function saveForm(form,url,modal,statusSubmit,method = "post"){
    var result = false;
    var validate = false;
    var msg = null;
    if(statusSubmit == 1){//new
        msg = 'Menambahkan';
        validate = validateInput(form);
    }else if(statusSubmit == 2){//update
        msg = 'Mengubah';
        validate = validateInput(form,['password']);
    }
    if(validate){
        $.ajax({
            type: method,
            url: url,
            data: form.serialize()+ '&_method=' + method,
            dataType: "JSON",
            success: function (response) {
                $.destroyModal(modal);
                $('table').DataTable().destroy();
                setDataTable();
                iziToast.success({
                    title: 'Success',
                    message: 'Success '+msg+' data',
                    position: 'topRight'
                });
                result = true;
            }
        });
    }
    return result;
}
setNumeric();
</script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

