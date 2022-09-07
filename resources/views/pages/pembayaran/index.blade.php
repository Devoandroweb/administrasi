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
var _CH_TGG_BEFORE = [];
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
    var data = e.params.data;
    _ID_SISWA = data.id;
    _SPP_BULAN_CHOUSE = [];
    _JSON_SPP = [];
    searchBiaya(data.id);
});


$(document).on('click',"#btn-modal-simpan",function (e) { 
    e.preventDefault();
    checkedSpp();
    checkedTggNow();
    generateRowCostNow(_RESPONSE_TGG_NOW);
    buildTrDetailSpp(_CH_SPP);

});

$(document).on("keyup",".nominal-bayar", function () {
    
    var valThis = $(this).val().split(".").join("");
    var dataVal = $(this).attr("data-val");
    // console.log(dataVal);
    if(parseInt(valThis) > parseInt(dataVal)){
        setNumeric();
        $(this).autoNumeric('set',dataVal);
    }
    if(totalBayar() != 0){
        $(".btn-save").removeAttr('disabled');
    }else{
        $(".btn-save").attr('disabled','disabled');
    }
    $('input[name=total]').autoNumeric('set',totalBayar());
});


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
                $("#data tbody").html("");
                // _CH_SPP = [];
                _CH_TGG_NOW = [];
                _CH_TGG_BEFORE = [];
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
$(".btn-change").click(function (e) { 
    e.preventDefault();
    buildHtmlBeforeAllCostModal(_RESPONSE_SPP,_RESPONSE_TGG_NOW,_RESPONSE_TGG_BEFORE);
    $('#modal-select-bayar').click();
    
});
//--------------------------------------- END DOM ---------------
//custom funtion
function searchBiaya(id_siswa){
    
    $.ajax({
        url: "{{url('pembayaran-cost-siswa')}}/"+id_siswa,
        dataType: "JSON",
        success: function (response) {
            var itemCount = response.tgg_now.length + response.tgg_before.length;
            $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
            if(itemCount == 0){
                $("#data tbody").html("<tr><td colspan='4' class='text-center text-danger'><i>Tidak ada biaya Tertanggung</i></td></tr>");
            }else{
                _RESPONSE_SPP = response.spp;
                _RESPONSE_TGG_NOW = response.tgg_now;
                _RESPONSE_TGG_BEFORE = response.tgg_before;
                buildHtmlBeforeAllCostModal(_RESPONSE_SPP,_RESPONSE_TGG_NOW,_RESPONSE_TGG_BEFORE);
                $('#modal-select-bayar').click();
                
            }
            

        }
    });
}
function checkedSpp(){
    var sppChecked = $('#fire-modal-1').find(".c-spp");
    $.each(sppChecked, function (i, v) { 
        var namaBulan = $(this).val();
        if($(this).prop('checked')){
            if(!inObject(namaBulan,_CH_SPP,'nama_bulan')){
                _CH_SPP.push({nama_bulan:namaBulan,nominal:$(this).data('nominal'),index:i});
            }
            _CH_TGG_NOW.push(1);
        }else{
            removeInObject(_CH_SPP,'nama_bulan',namaBulan);
        }
    });
    console.log(_CH_SPP);
}
function checkedTggNow(){
    var tggNowChecked = $('#fire-modal-1').find(".c-tgg-now");
    $.each(tggNowChecked, function (i, v) { 
        if($(this).prop('checked')){
            var idAdm = $(this).data("id");
            _CH_TGG_NOW.push(idAdm);
        }
    });
}


function buildHtmlBeforeAllCostModal(spp,tgg_now,tgg_before){
    if(spp != null){
        _HTML_COST = buildChecboxSppModal(spp);
    }
    _HTML_COST += buildTggNowModal(tgg_now);
    _HTML_COST += buildTggBeforeModal(tgg_before);
    $('#fire-modal-1').find('.modal-body').html(_HTML_COST);
    
}
//buat checkbox spp di modal
function buildChecboxSppModal(spp){
    var checked = "";
    
    var html = '<div class="form-group">\
                    <label class="form-label">SPP TA Sekarang</label>\
                    <div class="selectgroup selectgroup-pills">';
                    for (let i = 0; i < _BULAN.length; i++) {
                        var nominalSpp = spp[_BULAN[i].toLowerCase()];
                        _JSON_SPP[_BULAN[i].toLowerCase()] = nominalSpp;
                        if(nominalSpp != 0){
                            if(inObject(_BULAN[i].toLowerCase(),_CH_SPP,'nama_bulan')){
                                checked = "checked";
                            }else{
                                checked = "";
                            }
                            html += '<label class="selectgroup-item">\
                            <input type="checkbox" name="spp_bulan" value="'+_BULAN[i].toLowerCase()+'" class="selectgroup-input c-spp" data-idja="1" data-nominal="'+nominalSpp+'" '+checked+'>\
                                <span class="selectgroup-button">'+_BULAN[i]+'</span>\
                            </label>';
                        }
                    }
        
        html +=    '</div>\
                </div>';
    return html;
    
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
            htmlTr += "</tr>";
            
    });
    // $("table tbody").html(htmlTr);
    $(".td-spp").closest('tr').after(htmlTr);
}

//buat checkbox tgg now
function buildTggNowModal(tgg_now = []){
    
    
    var html = "";
    var checked = "";
    html = '<div class="form-group">\
                    <label class="form-label">Tanggungan TA Sekarang</label>\
                    <div class="selectgroup selectgroup-pills">';
                        if(tgg_now.length != 0){
                            tgg_now.forEach(element => {
                                if(element.id_administrasi != 1){
                                    if(element.nominal != 0){

                                        if(inArray(element.id_administrasi,_CH_TGG_NOW)){
                                            checked = "checked";
                                        }else{
                                            checked = "";
                                        }
                                        html += '<label class="selectgroup-item">\
                                            <input type="checkbox" name="tgg_now" data-id="'+element.id_administrasi+'" data-nominal="'+element.nominal+'" value="'+element.nama+'" class="selectgroup-input c-tgg-now" '+checked+'>\
                                                <span class="selectgroup-button">'+element.nama+'</span>\
                                            </label>';
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
function buildTggBeforeModal(tgg_before = []){
    var html = "";
    var html_grup_checkbox = "";
    var html_checkbox = "";
    var ajaran = "";
    tgg_before.forEach(element => {

        if(element.ajaran != ajaran){
            ajaran = element.ajaran;
            html_checkbox = "";
        }else{
            html = "";
        }
        if(element.nominal != 0){
            html_checkbox += '<label class="selectgroup-item">\
                <input type="checkbox" name="tgg_now" value="'+element.nama_tunggakan+'" class="selectgroup-input">\
                <span class="selectgroup-button">'+element.nama_tunggakan+'</span>\
                </label>';
        }
        html_grup_checkbox = '<div class="form-group">\
                <label class="form-label">Tanggungan TA '+element.ajaran+'</label>\
                <div class="selectgroup selectgroup-pills">{HTML_CHECKBOX}</div></div>';
        html += html_grup_checkbox.replace('{HTML_CHECKBOX}',html_checkbox);
    });
    return html;
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
//buat row biaya saat ini
var _NO = 1;
function generateRowCostNow(data = []){

    console.log("cek tgg now -> ",data);
    console.log("cek tgg now ch -> ",_CH_TGG_NOW);
    var html = "";
    data.forEach(element => {
        if(inArray(element.id_jenis_administrasi,_CH_TGG_NOW)){
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
                        html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right numeric nominal-bayar no-"+_NO+"' data-val='"+element.nominal+"' value='0' "+readOnly+"/></td>";
                    }else{
                        html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right numeric d-none no-"+_NO+"' value='0' "+readOnly+"/></td>";

                    }
                }else{
                    html += "<input id='"+classSpp+"' type='text' name='nominal[]' class='form-control text-right nominal-bayar' value='0' readonly/></td>";
                }
                // html += "<td><input>"
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
            html += "</tr>";
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

