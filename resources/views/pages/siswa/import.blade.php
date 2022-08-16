@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')

<?php 
use App\Traits\Helper;
?>

<section class="section">
    <div class="section-header">
    <h1>Import Siswa</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('import_siswa') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
                <form action="" class="w-100" id="form-file">
                <div class="loader-line form-loader d-none"></div>
                <div class="form-group w-100 mt-2">
                    <div class="input-group">
                        <div class="custom-file mr-2">
                            <input name="file-import" type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Masukkan File Excel</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary mr-2 btn-exec btn-priview" style="border-radius:5px" type="button" disabled><i class="fas fa-eye"></i> Priview</button>
                            <button class="btn btn-success btn-exec btn-save" style="border-radius:5px" type="button" disabled><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    
                </div>
                </form>

            </div>
            <div class="card-body">
            
            <div class="table-responsive">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>No. Telp.</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
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
    $(".btn-exec").attr('disabled','disabled');
    $("#data").DataTable();
    $(".custom-file-input").change(function (e) { 
        e.preventDefault();
        var file = $(this)[0].files;
        var fileExt = file[0].name.split('.').pop();
        if(fileExt != 'xlsx'){
            $(".btn-priview").attr('disabled','disabled');
            $(this).closest('.input-group').siblings(".text-alert").remove();
            $(this).closest('.input-group').after('<i class="text-danger text-alert">File harus ber-extensi .xlsx</i>');
        }else{
            $(".btn-priview").removeAttr('disabled');
            $(this).siblings('.custom-file-label').text(file[0].name+" ("+Math.ceil(file[0].size/ 1024 )+" kb)");
        }
        readURL(this);
    });
    $("#form-file").submit(function (e) { 
        e.preventDefault();
        console.log(e);
        $(".btn-exec").attr('disabled','disabled');
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: new FormData(this),
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status){
                    var html = "";
                    var no = 1;
                    var btnSave = true;
                    if(response.data != null){
                        response.data.forEach(element => {
                            var bgWarning = "";
                            if(element.status_row == 1){
                                bgWarning = "bg-warning text-white";
                                btnSave = false;
                            }
                            html += "<tr class='"+bgWarning+"'>\
                                <td>"+no+"</td>\
                                <td>"+element.nis+"</td>\
                                <td>"+element.nama+"</td>\
                                <td>"+element.tempat_lahir+"</td>\
                                <td>"+element.tgl_lahir+"</td>\
                                <td>"+element.jk+"</td>\
                                <td>"+element.no_telp+"</td>\
                                <td>"+element.kelas+"</td>\
                                <td>"+element.alamat+"</td>\
                                <tr>";
                            no++;
                            
                        });
                        $("#data tbody").html(html);
                    }else{
                        window.location.href = '{{url("siswa")}}';
                    }
                    $(".btn-priview").removeAttr('disabled');
                    $(".msg").remove();
                    $("#data").before("<i class='text-danger msg'>"+response.msg+"</i>");
                    if(btnSave){
                        $(".btn-save").removeAttr('disabled');
                    }else{
                        $(".btn-save").attr('disabled','disabled');
                    }
                }
            }
        });
        
    });
    $(".btn-priview").click(function (e) { 
        $("#form-file").attr('action',"{{url('import-siswa-read')}}");
        $("#form-file").submit();
    });
    $(".btn-save").click(function (e) { 
        $("#form-file").attr('action',"{{url('import-siswa-save')}}");
        $("#form-file").submit();
    });
</script>
@endpush