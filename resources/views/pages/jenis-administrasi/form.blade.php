<form action="" id="form-data">
    <div class="form-group">
        <label>Nama Biaya</label>
        <input type="text" name="nama" class="form-control text-uppercase" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Kelas</label>
        <select id="kelas" class="form-control "
            name="id_kelas" autocomplete="off">
            <option value="" selected disabled> Pilih Kelas</option>
            @foreach (\App\Models\MKelas::all() as $item)
            <option value="{{$item->id_kelas}}">{{$item->nama." ".$item->jurusan->nama}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Nominal</label>
        <input type="text" name="biaya" class="form-control numeric" required="" autocomplete="off">
    </div>

</form>
