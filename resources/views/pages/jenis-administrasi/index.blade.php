@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Jenis Biaya</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('jenis_administrasi') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Masukkan Jenis Biaya sesuai Lembaga anda</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                <i class="fas fa-plus-circle"></i> Tambah Jenis Biaya
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
                    <th>Nama Biaya</th>
                    <th>Kelas</th>
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
<style>
.floating-button{
    position: fixed;
    bottom: 40px;
    right: 40px;
    z-index: 99;
    display: none;
}
.floating-button .btn-delete{
    width: 60px;
    height: 60px;
}
.floating-button .fas{
    font-size: 1.5em
}
</style>
<div class="floating-button" id="btn-float">
    <button type="button" class="btn btn-danger rounded-circle btn-delete" tooltip="Hapus yang di pilih"><i class="fas fa-trash fa-lg"></i></button>
</div>
@endsection
@push('js')
<script type="text/javascript" src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>
<script>
// CUKUP UBAH VARIABLE BERIKUT
var _STATUS_SUBMIT = 0;
var _TITLE_MODAL_ADD = "Tambah Jenis Biaya";
var _TITLE_MODAL_UPDATE = "Ubah Jenis Biaya";
var _ID_UPDATE = "";
var _URL_INSERT = '{{route("jenis-administrasi.store")}}';
var _URL_UPDATE = '{{url("jenis-administrasi")}}/';
var _URL_DATATABLE = '{{ url("datatable/jenis-administrasi") }}';
// SESUAIKAN COLUMN DATATABLE
// SESUAIKAN FIELD EDIT MODAL
setDataTable();
function setDataTable() {
    $('#data').DataTable({
        "stateSave": true,
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
                data: 'nama_biaya',
                name: 'nama_biaya',
                // searchable: false,
            },{
                data: 'kelas',
                name: 'kelas',
                // searchable: false,
            },{
                data: 'biaya',
                name: 'biaya',
            },{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }],
        });
    }
$('#data tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
    showMultiDelete();
});
$(document).on("click",".btn-delete",function(){
    var tr = $('#data tbody').find(".selected");
    var data = [];
    $.each(tr, function (indexInArray, valueOfElement) { 
        data.push($(this).find('input[name=delete]').val());
    });
    Swal.fire({
        title: 'Kamu Yakin?',
        text: "Menghapus data ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "{{url('jenis-administrasi-multidelete')}}",
                data: {delete:data},
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        iziToast.success({
                            title: 'Success',
                            message: response.msg,
                            position: 'topRight'
                        });
                        $('#data').DataTable().destroy();
                        setDataTable();
                        $("#btn-float").hide();
                    }
                }
            });
        }
    })
    
})
$(document).on('click','#btn-add-data',function(e){
    _STATUS_SUBMIT = 1;
    clearInput("#form-data");
    $("#fire-modal-1").find(".modal-title").text(_TITLE_MODAL_ADD);
    $('#jb-kelas').selectric('destroy');
    $("#fire-modal-1").find(".selectric").attr("multiple","multiple");
    initSelectic()
});
$(document).on('click','.edit',function(e){
    var modal = $("#fire-modal-1");
    $(this).closest('tr').removeClass("selected")
    showMultiDelete()
    clearInput("#form-data");
    e.preventDefault();
    $.ajax({
        type: "get",
        url: $(this).attr("href"),
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                $('#jb-kelas').selectric('destroy');
                $("#fire-modal-1").find(".selectric").removeAttr("multiple");
                _STATUS_SUBMIT = 2;
                modal.find(".modal-title").text(_TITLE_MODAL_UPDATE);
                _ID_UPDATE = response.data.key;
                modal.find("input[name=nama]").val(response.data.nama);
                modal.find("select[name=id_kelas]").val(response.data.id_kelas);
                toRupiah(modal.find("input[name=biaya]"),response.data.biaya);
                modal.modal("show");
                initSelectic()
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
    }],
    appended : function(current_modal){
        initSelectic()
    }
});
function initSelectic(){
    $('#jb-kelas').selectric({
        responsive: true,
        maxHeight:200,
        onBeforeInit: function() {
            console.log("after selectric")
            $(".selectric-input").attr("name","selectric")
        },
        onClose: function() {
        
            var value = $(this).val();
            if(typeof value == 'object'){
                $("input[name=kelas]").val(value.join(','));
            }else{
                $("input[name=kelas]").val(value);
            }
        },
        onChange: function(element) {
            $(element).change();
        }
    });
}
// submit data
function saveForm(form,url,modal,statusSubmit,method = "post"){
    var result = false;
    var validate = false;
    var msg = null;
    if(statusSubmit == 1){//new
        msg = 'Menambahkan';
        validate = validateInput(form,['id_kelas','kelas','']);
    }else if(statusSubmit == 2){//update
        msg = 'Mengubah';
        validate = validateInput(form,['id_kelas','kelas','']);
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
    }else{
        console.log("Not Complete Input")
    }
    return result;
}
setNumeric();

</script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

