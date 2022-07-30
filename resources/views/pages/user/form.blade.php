<form action="" id="form-data">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required="" autocomplete="off">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" required="">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Jenis Pengguna</label>
        <select id="role" class="form-control "
            name="role" autocomplete="off">
            <option value="" selected disabled> Pilih Jenis Pngguna</option>

            <option value="1">Admin</option>
            <option value="2">Bendahara</option>
            <option value="3">Kepala Sekolah</option>
            
        </select>
    </div>
</form>
