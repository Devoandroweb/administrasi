@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')
@push("style-library")
<link rel="stylesheet" href="{{asset('vendor')}}/select2/css/select2.min.css">
@endpush
<?php 
use App\Traits\Helper;
use App\Models\MSiswa;
?>
<form action="" id="data-pembayaran" class="w-100">
<section class="section">
    <div class="section-header">
        
        <div class="row w-100">
            <div class="col">
                <div class="form-group">
                        <label>Siswa</label>
                        <select id="siswa" class="form-control siswa" placeholer="">
                            @foreach(MSiswa::all() as $key)
                                <option value="{{encrypt($key->id_siswa)}}">{{$key->nis." - ".$key->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Nominal Uang</label>
                        <input type="text" name="nominal_pembayaran" class="form-control text-right numeric" required="" autocomplete="off" disabled>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Sisa Uang</label>
                        <input type="text" name="sisa_uang" class="form-control text-right numeric" required="" autocomplete="off" readonly>
                    </div>
                </div>
                
            </div>

    </div>
    <style>
        .floating-button{
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 99;
        }
        .floating-button .btn-save{
            width: 60px;
            height: 60px;
        }
        .floating-button .fas{
            font-size: 1.5em
        }
    </style>
    <div class="floating-button">
        <button type="button" class="btn btn-success rounded-circle btn-save" disabled tooltip="Simpan Pembayaran"><i class="fas fa-save fa-lg"></i></button>
    </div>
    <div class="section-body">
        <div class="card card-primary">
            <div class="card-body">
            <div class="table-responsive">
                
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th>Nama Biaya</th>
                    <th>Nominal</th>
                    <th>Bayar</th>
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
</form>
@endsection
@push('js')
<script type="text/javascript" src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>
<script>
$('.btn-save').attr('disabled','disabled');
var _ID_SISWA = 0;
$('.siswa').select2({
    placeholder: "Ketikkan NIS atau Nama Siswa",
}).val("").trigger("change");
$(".siswa").select2("val", "");
$('.siswa').on('select2:select', function (e) {
    var data = e.params.data;
    _ID_SISWA = data.id;
    searchBiaya(data.id);
    

});
setNumeric();
//proses cari biaya siswa
function searchBiaya(id_siswa){
    $.ajax({
        url: "{{url('pembayaran-cost-siswa')}}/"+id_siswa,
        dataType: "JSON",
        success: function (response) {
            $("input[name=nominal_pembayaran]").autoNumeric('set',0);
            var itemCount = response.tgg_now.length + response.tgg_before.length;
            $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
            if(itemCount == 0){
                $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
                console.log(itemCount);
                $('input[name=nominal_pembayaran]').attr('disabled','disabled');
            }else{
                $('input[name=nominal_pembayaran]').removeAttr('disabled');
                generateRowCostNow(response.tgg_now); 
                generateRowArrears(response.tgg_before);
            }

        }
    });
}
var _NO = 1;
//buat row biaya saat ini
function generateRowCostNow(data = []){
    var html = "";
    data.forEach(element => {
        var nominal = 0;
        if(element.nominal == 0){
            nominal = 'Lunas';
        }else{
            nominal = element.nominal;
        }
        html += "<tr>";
        html += "<td><input type='hidden' name='nama_biaya[]' value='"+element.nama+"'>"+element.nama+"</td>";
        html += "<td class='numeric'>"+nominal+"</td>";
        html += "<td>\
                <input type='hidden' name='id_jenis_administrasi[]' value='"+element.id_jenis_administrasi+"'/>\
                <input type='hidden' name='biaya[]' class='biaya' id='"+_NO+"' value='"+element.nominal+"' />\
                <input type='text' name='nominal[]' class='form-control text-right nominal-bayar numeric no-"+_NO+"' value='0' readonly/></td>";
        html += "<td><a href='#' class='text-danger remove-item'><i class='fas fa-trash'></i></a></td>";
        html += "</tr>";
        _NO++;
    });
    $("#data tbody").html(html);
    setNumeric();
}
function generateRowArrears(data = []){
    var html = "";
    var ajaran = "";
    data.forEach(element => {
        if(ajaran != element.ajaran){
            html += "<tr><td colspan='4' class='bg-light text-center'>"+element.ajaran+"</td></tr>";
            ajaran = element.ajaran;
        }
        var nominal = 0;
        if(element.nominal == 0){
            nominal = 'Lunas';
        }else{
            nominal = element.nominal;
        }
        html += "<tr>";
        html += "<td><input type='hidden' name='nama_biaya_tunggakan[]' value='"+element.nama_tunggakan+"'>"+element.nama_tunggakan+"</td>";
        html += "<td class='numeric'>"+nominal+"</td>";
        html += "<td>\
                <input type='hidden' name='tahun_ajaran[]' value='"+element.ajaran+"'/>\
                <input type='hidden' name='biaya_tunggakan[]' class='biaya' id='"+_NO+"' value='"+element.nominal+"'/>\
                <input type='text' name='nominal_tunggakan[]' class='form-control nominal-bayar text-right numeric no-"+_NO+"' value='0' readonly/></td>";
        html += "<td><a href='#' class='text-danger remove-item'><i class='fas fa-trash'></i></a></td>";
        html += "</tr>";
        _NO++;
    });
    $("#data tbody").append(html);
    setNumeric();
}
$(document).on('click','.remove-item',function(e){
    $(this).closest('tr').remove();
    var uang = $("input[name=nominal_pembayaran]").val().split('.').join('');
    calculatePembayaran(uang);
});
$("input[name=nominal_pembayaran]").keyup(function (e) { 
    var uang = $(this).val().split('.').join('');
    if(uang == ""){
        uang = 0;
    }
    var sisa_uang = calculatePembayaran(uang);
    if(uang != 0 && sisa_uang != uang){
        $('.btn-save').removeAttr('disabled');
    }else{
        $('.btn-save').attr('disabled','disabled');
    }
    
});
function calculatePembayaran(uang = 0){
    var sisa_uang = 0;
    var allCost = $('.biaya');
    if(uang == ""){
        uang = 0;
    }
   
    for (let i = allCost.length; i >= 1; i--) {

        var inputTarget = allCost[i-1].attributes.id.value;
        if(parseInt(uang) <= parseInt(allCost[i-1].value)){ //jika uang lebih kecil atau sama dengan biaya
            $(".no-"+inputTarget).autoNumeric('set',uang);
            uang = 0;
        }else{ // jika uang lebih besar dengan biaya
            sisa_uang = parseInt(uang) - parseInt(allCost[i-1].value);
            $(".no-"+inputTarget).autoNumeric('set',parseInt(allCost[i-1].value));
        }
        $("input[name=sisa_uang").autoNumeric('set',sisa_uang);
        setNumeric();
        return sisa_uang;
    }

    
}
//buat row biaya tunggakan
$(document).on('keyup','.nominal-bayar', function () {
    
});
$(".btn-save").click(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "{{url('pembayaran-save')}}/"+_ID_SISWA,
        data: $("#data-pembayaran").serialize(),
        dataType: "JSON",
        success: function (response) {
            
        }
    });
});
</script>
@endpush

