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
            <div class="card-header-action">
                <a href="{{url('siswa-import')}}" class="btn btn-warning mr-2">
                Import Siswa
                </a>
            </div><div class="card-header-action">
                <a href="{{$url}}" class="btn btn-primary" id="btn-add-data">
                Tambah Siswa
                </a>
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
    setDataTable();
    function setDataTable() {
        $('#data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("datatable/siswa") }}',
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

