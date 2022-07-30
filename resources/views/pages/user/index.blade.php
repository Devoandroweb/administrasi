@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>User Managament</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('user_management') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Daftarkan Pengguna untuk bisa menggunakan Apikasi</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                Tambah Pengguna
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>Jenis Pengguna</th>
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
// CUKUP UBAH VARIABLE BERIKUT
var _STATUS_SUBMIT = 0;
var _TITLE_MODAL_ADD = "Tambah User";
var _TITLE_MODAL_UPDATE = "Ubah User";
var _ID_UPDATE = "";
var _URL_INSERT = '{{route("user.store")}}';
var _URL_UPDATE = '{{url("user")}}/';
var _URL_DATATABLE = '{{ url("datatable/user") }}';
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
                data: 'name',
                name: 'name',
            },{
                data: 'email',
                name: 'email',
            },{
                data: 'role_convert',
                name: 'role_convert',
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
                modal.find("input[name=username]").val(response.data.name);
                modal.find("input[name=email]").val(response.data.email);
                modal.find("select[name=role]").val(response.data.role);
                modal.modal("show");
            }
        }
    });
});


// open modal ---------------------------------------------------------------------
$('#btn-add-data').fireModal({
    title: _TITLE_MODAL_ADD,
    body: '<?= Helper::includeAsJsString("pages.user.form") ?>',
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
                        'PUT',
                        ['password']
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


//check username ------------------------------------------------------------
$(document).on('keyup','input[name=username]',function(){
    var el = $(this);
    checkUsername('{{url("user-checkusername?q=")}}'+el.val(),el);
});
$(document).on('change','input[name=username]',function(){
    var el = $(this);
    checkUsername('{{url("user-checkusername?q=")}}'+el.val(),el);
});
// funtion all
function checkUsername(url,input){
    $.ajax({
        type: "get",
        url: url,
        data:{_method:'other'},
        dataType: "JSON",
        success: function (response) {
            if(response.data > 0){
                input.siblings(".invalid-feedback").remove();
                input.addClass('is-invalid');
                input.after('<div class="invalid-feedback">Username ini sudah di gunakan.</div>')
            }else{
                input.removeClass('is-invalid');
                input.siblings(".invalid-feedback").remove();
                
            }
        }
    });
}
//----------------------------------------------------------------------------

</script>

<script type="text/javascript" src="{{asset('assets/js/save.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>
@endpush

