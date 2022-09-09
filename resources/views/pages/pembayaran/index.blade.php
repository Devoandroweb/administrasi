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
<style>
    .expand:before{
        content: '';
        background: #c4c4c4;
        width: 1px;
        height: 63px;
        position: absolute;
        top: -44px;
    }
    .expand{
        width: 21px;
        background: #c4c4c4;
        height: 1px;
        position: relative;
        margin-left: 14px;
    }
</style>
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
        .floating-button .btn-save,.floating-button .btn-reset,.floating-button .btn-change{
            width: 60px;
            height: 60px;
        }
        .floating-button .fas{
            font-size: 1.5em
        }
    </style>
    <div class="floating-button">
        <button type="button" class="btn btn-info rounded-circle btn-change" tooltip="Ubah Pembayaran"><i class="fas fa-pencil-alt fa-lg"></i></button>
        <button type="button" class="btn btn-danger rounded-circle btn-reset" tooltip="Reset Nominal Pembayaran"><i class="fas fa-redo fa-lg"></i></button>
        <button type="button" class="btn btn-success rounded-circle btn-save" disabled tooltip="Simpan Pembayaran"><i class="fas fa-save fa-lg"></i></button>
    </div>
    <div class="section-body">
        <div class="card card-primary">
            <div class="card-body">
            <div class="">
                <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                    <th>Nama Biaya</th>
                    <th width="5%">Bulan</th>
                    <th>Biaya Tanggungan</th>
                    <th>Bayar</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Total</b></td>
                        <td>
                            <b class="total">-</b>
                            <input type="hidden" name="total" class="total">
                        </td>
                    </tr>
                </tfoot>
                </table>

            </div>
            </div>
        </div>
</section>
</form>

<button type="button" class="d-none" id="modal-select-bayar">Bayar Apa?</button>
@endsection
@push('js')
<script type="text/javascript" src="{{asset('vendor/autonumeric/autoNumeric.js')}}"></script>
<script>
var _AUTOMATIC_CALC = false;
var bulan = '{{date("m")}}';
var _ID_SISWA = 0;
var bagdeSuccess = '<span class="badge badge-success">Lunas</span>';
var _JSON_SPP = [];
var _SPP_BULAN_CHOUSE = [];
var _HTML_COST = '';

var _CH_SPP = [];
var _CH_TGG_NOW = [];
var _CH_JTGG_NOW = [];
var _CH_TGG_BEFORE = [];

var _CH_SPP_DRAFT = [];
var _CH_JTGG_NOW_DRAFT = [];
var _CH_TGG_BEFORE_DRAFT = [];

var _RESPONSE_SPP = [];
var _RESPONSE_TGG_NOW = [];
var _RESPONSE_TGG_BEFORE = [];
var _BULAN = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
$("input[name=automatic_hitung]").prop('checked',false);
$("input[name=automatic_hitung]").attr('disabled',"disabled");
$('.btn-save').attr('disabled','disabled');
$('.siswa').select2({
    placeholder: "Ketikkan NISN atau Nama Siswa",
}).val("").trigger("change");
$(".siswa").select2("val", "");

setNumeric();
//proses cari biaya siswa
////-----------------------------------------------------------
// DOM ----------------------------------------------------

$('.siswa').on('select2:select', function (e) {
    _SPP_BULAN_CHOUSE = [];
    _JSON_SPP = [];
    if(_ID_SISWA !== 0){
        Swal.fire({
            title: 'Kamu yang mengganti pembayarannya?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                var data = e.params.data;
                // _ID_SISWA = data.id;
                searchBiaya(data.id);
            }
        })
    }else{
        var data = e.params.data;
        // _ID_SISWA = data.id;
        searchBiaya(data.id);
    }
    console.log("id siswa -> "+_ID_SISWA);

    
});

$(document).on("keyup",".nominal-bayar", function () {
    
    var valThis = $(this).val().split(".").join("");
    var dataVal = $(this).attr("data-val");
    // console.log(dataVal);
    if(parseInt(valThis) > parseInt(dataVal)){
        setNumeric();
        $(this).autoNumeric('set',dataVal);
    }
    enableOrDisableBtnSave();
    
});
function enableOrDisableBtnSave(){
    if(totalBayar() != 0){
        $(".btn-save").removeAttr('disabled');
    }else{
        $(".btn-save").attr('disabled','disabled');
    }
}

$( document ).ajaxStart(function() {
    loadingLine(true);
});
$( document ).ajaxComplete(function() {
    loadingLine();
});
//hitung total bayar spp
$(document).on('keyup',".bayar_spp",function(){
    totalSppYgdiBayar();

});
$(document).on('change',".bayar_spp",function(){
    updateSppObject($(this));
});
function totalSppYgdiBayar(){
    var totalSppYgdiBayar = 0;
    $.each($('.bayar_spp'), function (i, e) { 
         totalSppYgdiBayar += parseInt((e.value).split(".").join(""));
    }); 
    $("#td-spp").val(totalSppYgdiBayar);
}
function updateSppObject(e){
    var nominalInputSspp = e.val().split(".").join("");
    var namaBulanInputSspp = e.data('key').toLowerCase();
    updateObject(_CH_SPP,"nama_bulan",namaBulanInputSspp,"nominal",parseInt(nominalInputSspp));
}
//build modal
$('#modal-select-bayar').fireModal({
    title: "Mau Bayar apa aja ?",
    body: _HTML_COST,
    buttons: [
    {
            submit: false,
            class: 'btn btn-primary',
            id: 'btn-modal-simpan',
            text: 'Simpan',
            handler: function(current_modal) {
                
                // _CH_SPP = [];
                // _CH_TGG_NOW = [];
                // _CH_TGG_BEFORE = [];
                $.destroyModal(current_modal);

            }
    },
    {
        text: 'Close',
        class: 'btn btn-secondary',
        handler: function(current_modal) {
            $.destroyModal(current_modal);
            console.log("id siswa -> "+_ID_SISWA);
        
        }
    }
    ]
});
// button bottom navbar
$(".btn-reset").click(function (e) { 
    e.preventDefault();
    setNumeric();
    $(".nominal-bayar").autoNumeric('set',0);
    
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
$(document).on('click',"#btn-modal-simpan",function (e) { 
    _ID_SISWA = $(this).data('idsiswa');
    e.preventDefault();
    getChoouseSpp();
    getChoouseTggNow();
    getChoouseTggBefore();
    generateRowCostNow(_RESPONSE_TGG_NOW);
    generateRowArrears(_RESPONSE_TGG_BEFORE);
    buildTrDetailSpp(_CH_SPP);
    enableOrDisableBtnSave();
});
$(".btn-change").click(function (e) { 
    e.preventDefault();
    if(_ID_SISWA != 0){
        $('#fire-modal-1').find('.modal-body').html("");
        buildHtmlBeforeAllCostModal(_RESPONSE_SPP,_RESPONSE_TGG_NOW,_RESPONSE_TGG_BEFORE,true);
        $('#modal-select-bayar').click();
        console.log("id siswa -> "+_ID_SISWA);
        console.log("Before Simpan : ",_CH_TGG_NOW);
        console.log(_CH_JTGG_NOW);
    }
});

    // -- Remove List --- //
$(document).on('click','.remove-spp', function () {
    $(this).closest('tr').remove();
    removeInObject(_CH_SPP,"nama_bulan",$(this).data('key'));
    if(_CH_SPP.length == 0){
        $(".td-spp").closest('tr').remove();
    }
    totalBayar();
});
$(document).on('click','.remove-adm-now', function () {
    $(this).closest('tr').remove();
    removeInArray(_CH_TGG_NOW,$(this).data('keyid'));
    removeInArray(_CH_JTGG_NOW,$(this).data('keyidj'));
    if($(this).data('keyidj') == 1){
        _CH_SPP = [];
        $(".remove-spp").closest('tr').remove();
    }
    totalBayar();
}); 
$(document).on('click','.remove-adm-before', function () {
    $(this).closest('tr').remove();
    removeInArray(_CH_TGG_BEFORE,$(this).data('keyid'));
    totalBayar();
}); 
//--------------------------------------- END DOM ---------------
//custom funtion
function searchBiaya(id_siswa){
    _ID_SISWA = 0;
    _RESPONSE_SPP = [];
    _RESPONSE_TGG_NOW = [];
    _RESPONSE_TGG_BEFORE = [];
    $.ajax({
        url: "{{url('pembayaran-cost-siswa')}}/"+id_siswa,
        dataType: "JSON",
        success: function (response) {
            var itemCount = response.tgg_now.length + response.tgg_before.length;
            // $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
            if(itemCount == 0){
                $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
            }else{
                $("#data tbody").html("");
                totalBayar();
                _HTML_COST  = "";
                $("#btn-modal-simpan").attr("data-idsiswa",id_siswa);
                _RESPONSE_SPP = response.spp;
                _RESPONSE_TGG_NOW = response.tgg_now;
                _RESPONSE_TGG_BEFORE = response.tgg_before;
                buildHtmlBeforeAllCostModal(_RESPONSE_SPP,_RESPONSE_TGG_NOW,_RESPONSE_TGG_BEFORE);
                $('#modal-select-bayar').click();
                
            }
            

        }
    });
}
function getChoouseSpp(){
    var sppChecked = $('#fire-modal-1').find(".c-spp");
    $.each(sppChecked, function (i, v) { 
        var namaBulan = $(this).val();
        if($(this).prop('checked')){
            if(!inObject(namaBulan,_CH_SPP,'nama_bulan')){
                _CH_SPP.push({nama_bulan:namaBulan,nominal:$(this).data('nominal'),index:i});
            }
            _CH_TGG_NOW.push(1);
            _CH_JTGG_NOW.push(1);
        }else{
            removeInObject(_CH_SPP,'nama_bulan',namaBulan);
        }
    });
}
function getChoouseTggNow(){
    var tggNowChecked = $('#fire-modal-1').find(".c-tgg-now");
    $.each(tggNowChecked, function (i, v) { 
        if($(this).prop('checked')){
            var idAdm = $(this).data("id");
            var idJAdm = $(this).data("idj");
            _CH_TGG_NOW.push(idAdm);
            _CH_JTGG_NOW.push(idJAdm);
        }
    });
    console.log("After Simpan : ",_CH_TGG_NOW);
    console.log(_CH_JTGG_NOW);
}
function getChoouseTggBefore(){
    var tggBeforeChecked = $('#fire-modal-1').find(".c-tgg-before");
    $.each(tggBeforeChecked, function (i, v) { 
        if($(this).prop('checked')){
            var idTgg = $(this).data('id');
            _CH_TGG_BEFORE.push(idTgg);
        }
    });
}


function buildHtmlBeforeAllCostModal(spp,tgg_now,tgg_before,status = false){ // status : dari respon opo edit (true:edit)
    _HTML_COST = "";
    if(spp != null){
        _HTML_COST = buildChecboxSppModal(spp,status);
    }
    _HTML_COST += buildTggNowModal(tgg_now,status);
    _HTML_COST += buildTggBeforeModal(tgg_before,status);
    
    $('#fire-modal-1').find('.modal-body').html(_HTML_COST);
    
}
//buat checkbox spp di modal
function buildChecboxSppModal(spp,status){
    var show = true;
    
    var html = '<div class="form-group">\
                    <label class="form-label">SPP TA Sekarang</label>\
                    <div class="selectgroup selectgroup-pills">';
                    for (let i = 0; i < _BULAN.length; i++) {
                        var nominalSpp = spp[_BULAN[i].toLowerCase()];
                        _JSON_SPP[_BULAN[i].toLowerCase()] = nominalSpp;
                        if(nominalSpp != 0){
                            if(status){
                                if(inObject(_BULAN[i].toLowerCase(),_CH_SPP,'nama_bulan')){
                                    show = false;
                                }else{
                                    show = true;
                                }
                            }
                            if(show){
                                html += '<label class="selectgroup-item">\
                                <input type="checkbox" name="spp_bulan" value="'+_BULAN[i].toLowerCase()+'" class="selectgroup-input c-spp" data-idja="1" data-nominal="'+nominalSpp+'">\
                                    <span class="selectgroup-button">'+_BULAN[i]+'</span>\
                                </label>';
                            }
                        }
                    }
        
        html +=    '</div>\
                </div>';
    return html;
    
}



//buat checkbox tgg now
function buildTggNowModal(tgg_now = [],status = false){
    
    
    var html = "";
    var show = true;
    html = '<div class="form-group">\
                    <label class="form-label">Tanggungan TA Sekarang</label>\
                    <div class="selectgroup selectgroup-pills">';
                        if(tgg_now.length != 0){
                            tgg_now.forEach(element => {
                                if(element.id_jenis_administrasi != 1){
                                    if(element.nominal != 0){
                                        if(status){
                                            if(inArray(element.id_administrasi,_CH_TGG_NOW) && inArray(element.id_jenis_administrasi,_CH_JTGG_NOW)){
                                                show = false;
                                            }else{
                                                show = true;
                                            }
                                        }
                                        if(show){
                                            html += '<label class="selectgroup-item">\
                                                <input type="checkbox" name="tgg_now" data-id="'+element.id_administrasi+'" data-idj="'+element.id_jenis_administrasi+'" data-nominal="'+element.nominal+'" value="'+element.nama+'" class="selectgroup-input c-tgg-now">\
                                                    <span class="selectgroup-button">'+element.nama+'</span>\
                                                </label>';
                                        }
                                    }
                                }
                            });
                        }else{
                            html += '<div class="text-center text-danger">Tidak ada tannggungan</div>';
                        }
        html +=    '</div>\
                </div>';
    return html;
}
function buildTggBeforeModal(tgg_before = [],status = false){
    var html = "";
    var html_grup_checkbox = "";
    var html_checkbox = "";
    var ajaran = "";
    var ajaran1 = "";
    var htmlAll = "";
    var show = true;
    var header = "";
    var i = 0;
    tgg_before.forEach(element => {
        // cek ajaran, jika ajaran ajaran tidak sama maka buat header
        if(ajaran != element.ajaran){
            html_checkbox += '<div cass="w-100" style="font-weight: 600;color: #34395e;font-size: 12px;letter-spacing: 0.5px">\
                <label class="form-label">Tanggungan TA '+element.ajaran+'</label></div>';
            ajaran = element.ajaran
        }

        if(element.nominal != 0){
            if(status){
                if(inArray(element.id_tunggakan,_CH_TGG_BEFORE)){
                    show = false;
                }else{
                    show = true;
                }
            }
            if(show){
                html_checkbox += '<label class="selectgroup-item" style="margin-bottom: 33px;">\
                    <input type="checkbox" name="tgg_now" value="'+element.nama_tunggakan+'" data-id="'+element.id_tunggakan+'" class="selectgroup-input c-tgg-before">\
                    <span class="selectgroup-button rounded-pill mr-2">'+element.nama_tunggakan+'</span>\
                    </label>';
            }
        }
        
        
        i++;
    });
    return html_checkbox;
}
//buat pilihan bayar
function buildAllCost(spp = [],tgg_now = [],tgg_before = []){
    generateRowCostNow(tgg_now,spp);
    generateRowArrears(tgg_before);

    $("select[name=bulan_spp]").prop('selectedIndex', (parseInt(bulan)-1));
    var html = '<tr><td><td><td>\
                <b>Total</b>\
            </td>\
            <td>\
                <input type="text" name="total" class="form-control text-right numeric" required="" autocomplete="off" value="0" readonly>\
            </td></tr>';
    $("#data tbody").append(html);
}
function buildTrDetailSpp(bulan){
    var htmlTr = "";
    _CH_SPP.sort(compare);
    bulan.forEach(e => {
        
            console.log(true);
            htmlTr += "<tr class='tr-spp tr-spp-"+e.nama_bulan+"'>";
            htmlTr += "<td><div class='expand'></div>";
            htmlTr += "<td class=''><i>"+capitalize(e.nama_bulan)+'</i>';
            htmlTr += "<td class='numeric'>"+_JSON_SPP[e.nama_bulan];
            htmlTr += "<td>";
            htmlTr += "<input type='text' name='bayar_spp[]' class='form-control text-right numeric bayar_spp nominal-bayar no-"+_NO+"' data-val='"+_JSON_SPP[e.nama_bulan]+"' data-key='"+e.nama_bulan+"' value='"+searchInObject(_CH_SPP,"nama_bulan",e.nama_bulan).nominal+"'/></td>";
            htmlTr += "<td><a href='#' class='text-danger remove-spp' data-key='"+e.nama_bulan+"'><i class='fas fa-trash-alt'></i></a></td>";
            htmlTr += "</tr>";
            
    });
    // $("table tbody").html(htmlTr);
    $(".td-spp").closest('tr').after(htmlTr);
    setNumeric();

}
//buat row biaya saat ini
var _NO = 1;
function generateRowCostNow(data = []){

    
    var html = "";
    data.forEach(element => {
        if(inArray(element.id_jenis_administrasi,_CH_JTGG_NOW)){
            var nominal = 0;
            var print = true;
            if(element.nominal == 0){
                nominal = bagdeSuccess;
                print = false;
            }
            nominal = element.nominal;
            var classSpp = '';
            var readOnly = '';
            //pprint -----------------------------------------------------------------------------------
            if(print){
                html += "<tr>";
                html += "<td><input type='hidden' name='nama_biaya[]' value='"+element.nama+"'>"+element.nama+"</td>";
                html += "<td></td>";
                if(element.id_jenis_administrasi == 1){
                    classSpp = "td-spp";
                    nominal = 0;
                    readOnly = 'readonly';
                    console.log('ini spp');
                }
                html += "<td class='numeric "+classSpp+"'>"+nominal+"</td>";
                html += "<td>\
                        <input type='hidden' name='id_jenis_administrasi[]' value='"+element.id_jenis_administrasi+"'/>\
                        <input type='hidden' name='biaya[]' class='biaya "+classSpp+"' id='"+_NO+"' value='"+element.nominal+"' />";
                if(element.nominal != 0){
                    if(element.id_jenis_administrasi != 1){
                        html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right numeric nominal-bayar no-"+_NO+"' data-val='"+element.nominal+"' value='"+element.nominal+"' "+readOnly+"/></td>";
                    }else{
                        html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right numeric d-none no-"+_NO+"' value='0' "+readOnly+"/></td>";

                    }
                }else{
                    html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right nominal-bayar' value='0' readonly/></td>";
                }
                html += "<td><a href='#' class='text-danger remove-adm-now' data-keyid='"+element.id_administrasi+"' data-keyidj='"+element.id_jenis_administrasi+"'><i class='fas fa-trash-alt'></i></a></td>";
                html += "</tr>";
            }
            //---------------------------------------------------------------------------------------
            _NO++;
        }
    });

    $("#data tbody").html(html);
    setNumeric();
}

//buat row biaya tanggungan
function generateRowArrears(data = []){
    var html = "";
    var ajaran = "";
    console.log("cek tgg before -> ",data);
    console.log("cek tgg before ch -> ",_CH_TGG_BEFORE);
    data.forEach(element => {
        if(inArray(element.id_tunggakan,_CH_TGG_BEFORE)){
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
                    html += "<input type='text' name='nominal_tunggakan[]' class='form-control nominal-bayar text-right numeric no-"+_NO+"' data-val='"+element.nominal+"' value='"+element.nominal+"'/></td>";
                }else{
                    html += "<input type='text' name='nominal_tunggakan[]' class='form-control text-right' value='0' readonly/></td>";
                }
                html += "<td><a href='#' class='text-danger remove-adm-before' data-keyid='"+element.id_tunggakan+"'><i class='fas fa-trash-alt'></i></a></td>";
                html += "</tr>";
            }
        }
        //---------------------------------------------------------------------------------------------------
        _NO++;
    });
    $("#data tbody").append(html);
    setNumeric();
}
//buat select bulan
function generateSelectMonth(id_jenis_administrasi,spp){
    
    if(id_jenis_administrasi == 1){
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var html = "<div style='width:200px !important; max-width:200px !important;'>";
            html += "<input type='hidden' name='bulan_spp'>";
            // html += "<input type='hidden' name='bayar_spp'>";
            html += "<select id='select-bulan' class='form-control' multiple>";
                    html += "<option value='' disabled selected>Pilih Bulan</option>";
                    for (let i = 0; i < bulan.length; i++) {
                        var nominalSpp = spp[bulan[i].toLowerCase()];
                        _JSON_SPP[bulan[i].toLowerCase()] = nominalSpp;
                        if(nominalSpp != 0){
                            html += "<option value='"+bulan[i].toLowerCase()+"'>"+bulan[i]+"</option>";
                        }
                    }
            html += "</select>";
            html += "</div>";
        // $(".coba").html(html);
        console.log(_JSON_SPP);
        // console.log(_JSON_SPP['januari']);
        return html;
    }
    return "-";
}

function totalBayar(){
    var nominalBayar = $(".nominal-bayar");
    var totalBayar = 0;
    $.each(nominalBayar, function (i, e) { 
        totalBayar = totalBayar + parseInt((e.value).split(".").join(""));
    });
    $(".total").val(totalBayar);
    toRupiah($(".total"),totalBayar);
    setNumeric();
    return totalBayar;
}
function resetNominalBayar(){
    $(".nominal-bayar").val(0);
}

function caculateSpp(spp){
    // var spp = spp.split(",");
    var totalSpp = 0;
    var bayarSpp = [];
    var i = 0;
    spp.forEach(element => {
        console.log("calculate spp "+element);
        console.log(parseInt(_JSON_SPP[element]));
        totalSpp += parseInt(_JSON_SPP[element]);
        bayarSpp[i] = _JSON_SPP[element];
        i++;
    });
    var result = {bayarspp:bayarSpp,totalspp:totalSpp};
    return result;
}

function loadingLine(kode = false){
    if(kode){
        $('.form-loader').removeClass('d-none');
    }else{
        $('.form-loader').addClass('d-none');
    }
}

</script>
@endpush

