<form action="" id="form-data">
    <div class="form-group">
        <label>Nama Biaya</label>
        <input type="text" name="nama" class="form-control text-uppercase" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Kelas</label>
        <input type="hidden" name="kelas">
        <select id="jb-kelas" class="form-control selectric"
            name="id_kelas">
            <option value="" disabled> Pilih Kelas</option>
            @foreach (\App\Models\MKelas::all() as $item)
            @if($item->no_urut == 0)
            <option value="{{$item->id_kelas}}">{{$item->nama}}</option>
            @else
            <option value="{{$item->id_kelas}}">{{$item->nama." ".$item->jurusan->nama}}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Nominal</label>
        <input type="text" name="biaya" class="form-control numeric" required="" autocomplete="off">
    </div>
</form>
