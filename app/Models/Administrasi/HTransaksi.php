<?php

namespace App\Models\Administrasi;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HTransaksi extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $table = 'h_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['kode', 'tanggal', 'id_siswa', 'biaya', 'tunggakan'];
}
