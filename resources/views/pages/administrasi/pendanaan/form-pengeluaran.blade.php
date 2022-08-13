<div class="loader-line form-loader d-none mb-2"></div>
<form action="" id="form-data-peng">
    <div class="form-group">
        <label for="">Nama</label>
        <input type="text" name="nama" class="form-control" required="" autocomplete="off">
    </div>
    <table class="w-100">
        <tr class="font-weight-bold">
            <td><label>Nama Pengeluaran</label></td>
            <td></td>
            <td><label>Nominal</label></td>
        </tr>
        <tr>
            <td>
                <div class="form-group mb-0">
                    <input type="text" name="nama_pengeluaran[]" class="form-control" required="" autocomplete="off">
                </div>
            </td>
            <td valign="middle" class="text-center"><i class="fas fa-caret-left"></i> <i class="fas fa-caret-right"></i></td>
            <td>
                <div class="form-group mb-0">
                    <input type="text" name="nominal[]" class="form-control mb-0 numeric" required="" autocomplete="off">
                </div>
            </td>
        </tr>
    </table>
    
    
</form>
