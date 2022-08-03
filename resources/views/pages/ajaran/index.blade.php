@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
<section class="section">
    <div class="section-header">
    <h1>Kelola Tahun Ajaran</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('jurusan') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Masukkan Tahun Ajaran sesuai Lembaga anda</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                Tambah Tahun Ajaran
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
                    <th>Tahun Awal</th>
                    <th>Tahun Akhir</th>
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
<script>
// CUKUP UBAH VARIABLE BERIKUT
var _STATUS_SUBMIT = 0;
var _TITLE_MODAL_ADD = "Tambah Ajaran";
var _TITLE_MODAL_UPDATE = "Ubah Ajaran";
var _ID_UPDATE = "";
var _URL_INSERT = '{{route("ajaran.store")}}';
var _URL_UPDATE = '{{url("ajaran")}}/';
var _URL_DATATABLE = '{{ url("datatable/ajaran") }}';
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
                data: 'tahun_awal',
                name: 'tahun_awal',
            },{
                data: 'tahun_akhir',
                name: 'tahun_akhir',
            },{
                data: 'status_convert',
                name: 'status_convert',
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
                modal.modal("show");
            }
        }
    });
});


// open modal
$('#btn-add-data').fireModal({
    title: _TITLE_MODAL_ADD,
    body: '<?= Helper::includeAsJsString("pages.ajaran.form") ?>',
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

// change aktif
$(document).on('change','input[name=status]',function (e) { 
    // e.preventDefault();
    var _HREF = $(this).data('url');
    $.ajax({
        type: "get",
        url: _HREF,
        dataType: "JSON",
        success: function (response) {
            window.location.href = "{{url('dashboard')}}";
        }
    });
});

</script>
<script type="text/javascript" src="{{asset('assets/js/save.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/delete.js')}}"></script>

@endpush

