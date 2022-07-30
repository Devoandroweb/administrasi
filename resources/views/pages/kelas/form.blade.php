<form action="" id="form-data">
    <div class="form-group">
        <label>Nama Jurusan</label>
        <input type="text" name="nama" class="form-control" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Jurusan</label>
        <select id="role" class="form-control "
            name="role" autocomplete="off">
            <option value="" selected disabled> Pilih Jenis Pngguna</option>
            @foreach (MJurusan::all() as $item)
            <option value="1">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
</form>
