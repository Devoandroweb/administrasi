<?php use App\Models\MSiswa; ?>
<form action="" id="form-data">
    <div class="form-group">
        <label for="exampleInputEmail1">Siswa</label>
        <select id="siswa" class="form-control siswa-select"
            name="siswa">
            <option value="" disabled selected>Pilih Siswa</option>
            @foreach (MSiswa::all() as $item)
            <option value="{{$item->id_siswa}}" data-notelp="{{$item->no_telp}}">{{$item->nama." @ +".$item->no_telp}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>No Telp.</label>
        <input type="text" name="no_telp" class="form-control phone-number" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label>Text Chat</label>
        <textarea name="pesan" class="form-control" rows="6"></textarea>
    </div>
</form>
