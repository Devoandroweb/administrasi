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
    <div class="section-header d-block">
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Siswa</label>
                    <select id="siswa" class="form-control siswa" placeholer="">
                        @foreach(MSiswa::all() as $key)
                            <option value="{{encrypt($key->id_siswa)}}">{{$key->nisn." - ".$key->nama}}</option>
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
            <div class="col-1 d-flex align-items-center">
                <label class="custom-switch pl-0 automatic_hitung">
                <input type="checkbox" name="automatic_hitung" class="custom-switch-input">
                <span class="custom-switch-indicator"></span>
                </label>
            </div>
        </div>
        <div class="loader-line form-loader d-none"></div>
    </div>
    <style>
        .floating-button{
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 99;
        }
        .floating-button .btn-save,.floating-button .btn-reset{
            width: 60px;
            height: 60px;
        }
        .floating-button .fas{
            font-size: 1.5em
        }
    </style>
    <div class="floating-button">
        <button type="button" class="btn btn-danger rounded-circle btn-reset" tooltip="Reset Nominal Pembayaran"><i class="fas fa-redo fa-lg"></i></button>
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
                    <th>Bulan</th>
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
var _AUTOMATIC_CALC = false;
var bulan = '{{date("m")}}';
var _ID_SISWA = 0;
var bagdeSuccess = '<span class="badge badge-success">Lunas</span>';
$("input[name=automatic_hitung]").prop('checked',false);
$("input[name=automatic_hitung]").attr('disabled',"disabled");
$('.btn-save').attr('disabled','disabled');
$('.siswa').select2({
    placeholder: "Ketikkan NISN atau Nama Siswa",
}).val("").trigger("change");
$(".siswa").select2("val", "");
$(".automatic_hitung").click(function(){
    
    $("input[name=sisa_uang]").val(0);
    if($("input[name=automatic_hitung]").prop('checked')){
        $(".nominal-bayar").attr('readonly','readonly');
        _AUTOMATIC_CALC = true;
        $(".btn-reset").attr('disabled','disabled');
        resetNominalBayar();
        calculatePembayaran($("input[name=nominal_pembayaran]").val().split(".").join(""));
        enableSave($("input[name=nominal_pembayaran]").val().split(".").join(""),$("input[name=sisa_uang]").val());
    }else{
        $(".nominal-bayar").removeAttr('readonly');
        $(".btn-reset").removeAttr('disabled');
        _AUTOMATIC_CALC = false;
    }
})
setNumeric();
//proses cari biaya siswa

////-----------------------------------------------------------
// DOM ----------------------------------------------------
$(document).on('click','.remove-item',function(e){
    $(this).closest('tr').remove();
    var uang = $("input[name=nominal_pembayaran]").val().split('.').join('');
    calculatePembayaran(uang);
});
$("input[name=nominal_pembayaran]").keyup(function (e) { 
    openBtnSave($(this));
    calculaSisaUang();
});

$('.siswa').on('select2:select', function (e) {
    var data = e.params.data;
    _ID_SISWA = data.id;
    searchBiaya(data.id);
});

$(".btn-save").click(function (e) { 
    e.preventDefault();
    if(totalBayar() == 0){
        iziToast.error({
            title: 'Error',
            message: 'Harap isi salah satu input bayar',
        });
    }else{
        $.ajax({
            type: "post",
            url: "{{url('pembayaran-save')}}/"+_ID_SISWA,
            data: $("#data-pembayaran").serialize(),
            dataType: "JSON",
            success: function (response) {
                window.location.href = "{{url('pembayaran-cetak-struk')}}/"+response.data;
            }
        });
    }
});

$(document).on("change","#select-bulan", function () {
    getSppBulanan($(this).val(),$(this));
});
$(document).on("keyup",".nominal-bayar", function () {
    
    var valThis = $(this).val().split(".").join("");
    var dataVal = $(this).attr("data-val");
    // console.log(dataVal);
    if(parseInt(valThis) > parseInt(dataVal)){
        setNumeric();
        $(this).autoNumeric('set',dataVal);
    }
    if(_AUTOMATIC_CALC){
        var totalBayar = totalBayar();
        $("input[name=nominal_pembayaran]").autoNumeric('set',totalBayar);
    }else{
        calculaSisaUang();
    }
    // //open btn save
    // var uang = $("input[name=nominal_pembayaran]").val().split('.').join('');
    // var sisa_uang = $("input[name=sisa_uang]").val().split('.').join('');
    // if(uang == ""){
    //     uang = 0;
    // }
    // if(sisa_uang == ""){
    //     sisa_uang = 0;
    // }
    // enableSave(uang,sisa_uang);

});
$(".btn-reset").click(function (e) { 
    e.preventDefault();
    setNumeric();
    $(".nominal-bayar").autoNumeric('set',0);
    
});
$( document ).ajaxStart(function() {
    loadingLine(true);
});
$( document ).ajaxComplete(function() {
    loadingLine();
});
//--------------------------------------- END DOM ---------------
//custom funtion
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

                $("select[name=bulan_spp]").prop('selectedIndex', (parseInt(bulan)-1));
                getSppBulanan($("select[name=bulan_spp]").val());
                $("input[name=automatic_hitung]").removeAttr("disabled");
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
        var print = true;
        if(element.nominal == 0){
            nominal = bagdeSuccess;
            print = false;
        }
        nominal = element.nominal;
        var classSpp = '';
        //pprint -----------------------------------------------------------------------------------
        if(print){
            html += "<tr>";
            html += "<td><input type='hidden' name='nama_biaya[]' value='"+element.nama+"'>"+element.nama+"</td>";
            html += "<td>"+generateSelectMonth(element.id_jenis_administrasi)+"</td>";
            if(element.id_jenis_administrasi == 1){
                classSpp = "td-spp";
            }
            html += "<td class='numeric "+classSpp+"'>"+nominal+"</td>";
            html += "<td>\
                    <input type='hidden' name='id_jenis_administrasi[]' value='"+element.id_jenis_administrasi+"'/>\
                    <input type='hidden' name='biaya[]' class='biaya "+classSpp+"' id='"+_NO+"' value='"+element.nominal+"' />";
            if(element.nominal != 0){
                html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right nominal-bayar numeric no-"+_NO+"' data-val='"+element.nominal+"' value='0'/></td>";
            }else{
                html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right' value='0' readonly/></td>";
            }
            html += "<td><a href='#' class='text-danger remove-item'><i class='fas fa-trash'></i></a></td>";
            html += "</tr>";
        }
        //---------------------------------------------------------------------------------------
        _NO++;
    });
    $("#data tbody").html(html);
    setNumeric();
}
//buat row biaya tanggungan
function generateRowArrears(data = []){
    var html = "";
    var ajaran = "";
    data.forEach(element => {
        var print = true;
        if(ajaran != element.ajaran){
            html += "<tr><td colspan='5' class='bg-light text-center'>"+element.ajaran+"</td></tr>";
            ajaran = element.ajaran;
        }
        var nominal = 0;
        if(element.nominal == 0){
            print = false;
        }
        nominal = element.nominal;
        //print ----------------------------------------------------------------------------------------------
        if(print){
            html += "<tr>";
            html += "<td><input type='hidden' name='nama_biaya_tunggakan[]' value='"+element.nama_tunggakan+"'>"+element.nama_tunggakan+"</td>";
            html += "<td>-</td>";
            html += "<td class='numeric'>"+nominal+"</td>";
            html += "<td>\
                    <input type='hidden' name='tahun_ajaran[]' value='"+element.ajaran+"'/>\
                    <input type='hidden' name='biaya_tunggakan[]' class='biaya' id='"+_NO+"' value='"+element.nominal+"'/>";
            if(element.nominal != 0){
                html += "<input type='text' name='nominal_tunggakan[]' class='form-control nominal-bayar text-right numeric no-"+_NO+"' data-val='"+element.nominal+"' value='0'/></td>";
            }else{
                html += "<input type='text' name='nominal_tunggakan[]' class='form-control text-right' value='0' readonly/></td>";
            }
            html += "<td><a href='#' class='text-danger remove-item'><i class='fas fa-trash'></i></a></td>";
            html += "</tr>";
        }
        //---------------------------------------------------------------------------------------------------
        _NO++;
    });
    $("#data tbody").append(html);
    setNumeric();
}
//buat select bulan
function generateSelectMonth(id_jenis_administrasi){
    if(id_jenis_administrasi == 1){
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var html = "<select name='bulan_spp' id='select-bulan' class='form-control'>";
                    for (let i = 0; i < bulan.length; i++) {
                        html += "<option value='"+bulan[i].toLowerCase()+"'>"+bulan[i]+"</option>";
                    }
            html += "</select>";
        return html;
    }
    return "-";
}
//hitung pembayaran
function calculatePembayaran(uang = 0){
    var sisa_uang = 0;
    var allCost = $('.biaya');
    if(uang == ""){
        uang = 0;
    }
    var totalBiaya = 0;
    for (let i = allCost.length; i >= 1; i--) {

        var inputTarget = allCost[i-1].attributes.id.value;
        var cost = (allCost[i-1].value).split(".").join("");
        if(parseInt(uang) <= parseInt(cost)){ //jika uang lebih kecil atau sama dengan biaya
            $(".no-"+inputTarget).autoNumeric('set',uang);
            uang = 0;
        }else{ // jika uang lebih besar dengan biaya
            // uang = uang 
            uang = parseInt(uang) - parseInt(cost);
            $(".no-"+inputTarget).autoNumeric('set',parseInt(cost));
        }
    }

    setNumeric();
    $("input[name=sisa_uang]").autoNumeric('set',uang);
    return uang;

    
}
function getSppBulanan(bulan){
    $.ajax({
        type: "get",
        url: "{{url('biaya-spp-perbulan')}}/"+_ID_SISWA+"/"+bulan,
        dataType: "json",
        success: function (response) {
            if(response.status){
                $("#td-spp").attr('data-val',response.data);
                if(response.data != 0){
                    $("#td-spp").autoNumeric('init',{aPad:false, aDec: ',', aSep: '.'});
                    $(".td-spp").autoNumeric('init',{aPad:false, aDec: ',', aSep: '.'});
                    $('.td-spp').autoNumeric('set',response.data);
                    $('#td-spp').removeAttr('readonly');
                }else{
                    $('.td-spp').text(0);
                    $('#td-spp').attr('readonly','readonly');
                }

            }
        }
    });
}
function openBtnSave(e){
    var uang = e.val().split('.').join('');
    if(uang == ""){
        uang = 0;
    }
    var sisa_uang = 0;
    if(_AUTOMATIC_CALC){
        sisa_uang = calculatePembayaran(uang);
    }
    enableSave(uang,sisa_uang);
}
function enableSave(uang,sisa_uang){
    if(uang > 0 && sisa_uang < uang){
        $('.btn-save').removeAttr('disabled');
    }else{
        $('.btn-save').attr('disabled','disabled');
    }
}
function loadingLine(kode = false){
    if(kode){
        $('.form-loader').removeClass('d-none');
    }else{
        $('.form-loader').addClass('d-none');
    }
}
function calculaSisaUang(){
    var nominalPembayaran = $("input[name=nominal_pembayaran]").val().split(".").join("");
    var bayar = totalBayar();
    if(nominalPembayaran == ""){
        nominalPembayaran = 0;
    }
    if(nominalPembayaran < bayar){
        iziToast.error({
            title: 'error',
            displayMode:'replace',
            timeout : 0,
            extendedTimeout : 0,
            message: '<b>Uang tidak Cukup</b> <br> harap masukkan nominal uang dengan benar',
            position: 'topCenter'
        });
        $('.btn-save').attr('disabled','disabled');
        $("input[name=sisa_uang]").val(0);
    }else{
        var sisaUang = nominalPembayaran - bayar;
        setNumeric();
        $("input[name=sisa_uang]").autoNumeric('set',sisaUang);
        iziToast.destroy();
    }
    
    
}
function totalBayar(){
    var nominalBayar = $(".nominal-bayar");
    var totalBayar = 0;
    $.each(nominalBayar, function (i, e) { 
        totalBayar = totalBayar + parseInt((e.value).split(".").join(""));
    });
    setNumeric();
    return totalBayar;
}
function resetNominalBayar(){
    $(".nominal-bayar").val(0);
}
</script>
@endpush

