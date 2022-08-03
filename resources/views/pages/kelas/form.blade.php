<?php use App\Models\MJurusan; ?>
<form action="" id="form-data">
    <div class="form-group">
        <label>Nama Kelas</label>
        <input type="text" name="nama" class="form-control" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Jurusan</label>
        <select id="role" class="form-control "
            name="role" autocomplete="off">
            <option value="" selected disabled> Pilih Jurusan</option>
            @foreach (MJurusan::all() as $item)
            <option value="{{$item->id_jurusan}}">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
</form>
