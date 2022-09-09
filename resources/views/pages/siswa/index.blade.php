@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>
@include('pages.siswa.detail')

<section class="section">
    <div class="section-header">
    <h1>Data Siswa</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('siswa') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Data Siswa untuk mengelola Administrasi</h4>
            @if(auth()->guard('web')->user()->role == 3)
            <div class="card-header-action">
                <a href="{{url('export/siswa')}}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel"></i> Export Siswa
                </a>
            </div>
            @endif
            @if(auth()->guard('web')->user()->role != 3)
            <div class="card-header-action">
                <a href="{{$url}}" class="btn btn-primary mr-2" id="btn-add-data">
                <i class="fas fa-plus-circle"></i> Tambah Siswa
                </a>
            </div>
            <div class="card-header-action dropdown mr-2">
                <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><i class="fas fa-file-excel"></i> Import/Export</a>
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-126px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <li class="dropdown-title">Pilih Menu</li>
                    <li><a href="{{url('export/siswa')}}" class="dropdown-item">Export</a></li>
                    <li><a href="{{url('siswa-import')}}" class="dropdown-item">Import</a></li>
                </ul>
            </div>
            @endif
            <div class="card-header-action dropdown  mr-2">
                <a href="#" data-toggle="dropdown" class="btn btn-danger filter dropdown-toggle" aria-expanded="false"><i class="fas fa-filter"></i> Status : Aktif</a>
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-126px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <li class="dropdown-title">Pilih Status</li>
                    <li><a href="{{ url("datatable/siswa-aktif") }}" data-text="aktif" class="dropdown-item sub-filter">Aktif</a></li>
                    <li><a href="{{ url("datatable/siswa-nonaktif") }}" data-text="non aktif" class="dropdown-item sub-filter">Non Aktif</a></li>
                </ul>
            </div>
            
            </div>
            <div class="card-body">
            @if(session('msg'))
                <div class="alert alert-danger">{{session('msg')}}</div>
            @endif
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>NISN</th>
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
    var _URL_DATATABLE = '{{ url("datatable/siswa-aktif") }}';
    
    setDataTable();
    function setDataTable() {
        $('#data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: _URL_DATATABLE,
            },
            responsive: true,
            columns: [{
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '4%',
                    className: 'text-center'
                },{
                    data: 'nisn',
                    name: 'nisn',
                },{
                    data: 'nama',
                    name: 'nama',
                },{
                    data: 'jk',
                    name: 'jk',
                    searchable: false,
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }]
        });
    }
    //DOM
    $(".sub-filter").click(function (e) { 
        e.preventDefault();
        _URL_DATATABLE = $(this).attr('href');
        $('#data').DataTable().destroy();
        setDataTable();
        $(".filter").text("Filter : "+capitalize($(this).data('text')));
    });
    

    //modal
    // open modal
    $(document).on("click",".detail", function (e) {
        
        e.preventDefault();
        $.ajax({
            type: "get",
            url: $(this).attr('href'),
            dataType: "JSON",
            success: function (response) {
                var data = response.data;
                $(".d-nama").text(data.nama);
                $(".d-nisn").text(data.nisn);
                $(".d-tmp-lhr").text(data.tempat_lahir);
                $(".d-tgl-lhr").text(data.tgl_lhr);
                $(".d-jk").text(data.jk_text);
                $(".d-telp").text(data.no_telp);
                var kelas = "";
                if(data.id_kelas != 0){
                    $(".d-kelas").text(data.kelas.nama+' '+data.kelas.jurusan.nama);
                }else{
                    $(".d-kelas").text('Alumni');
                }
                $(".d-alamat").text(data.alamat);
                $("#modal-detail").modal('show');
            }
        });
    });
$(document).on('click','.delete',function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Kamu Yakin?',
            text: "Menghapus data ini akan menghapus semua data Administrasi yang di miliki oleh data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
            }).then((result) => {
            if (result.isConfirmed) {
                deleteData($(this).attr('href'),'post',{_method:'delete'});
            }
        })
    
});
function deleteData(url,type = "get",method = null){
    $.ajax({
        type: type,
        url: url,
        data : method,
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                iziToast.success({
                    title: 'Success',
                    message: response.msg,
                    position: 'topRight'
                });
                $('#data').DataTable().destroy();
                setDataTable();
            }
        }
    });
}
$( document ).ajaxStart(function() {
    loadingLine(true);
});
$( document ).ajaxComplete(function() {
    loadingLine();
});
</script>

@endpush

