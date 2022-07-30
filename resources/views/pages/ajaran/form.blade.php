@php 
    $_TAHUN = date('Y'); 
@endphp
<form action="" id="form-data">
    <div class="form-group">
        <label>Tahun Ajaran Dari</label>
        <select id="tahun_awal" class="form-control "
            name="tahun_awal" autocomplete="off">
            <option value="" selected disabled> Pilih Tahun</option>
            @for ($i = intval($_TAHUN); $i > 1999 ; $i--)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        <label>Tahun Ajaran Sampai</label>
        <select id="tahun_akhir" class="form-control "
            name="tahun_akhir" autocomplete="off">
            <option value="" selected disabled> Pilih Tahun</option>
            @for ($i = intval($_TAHUN); $i > 1999 ; $i--)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>
</form>
