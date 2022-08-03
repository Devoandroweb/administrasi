<?php

namespace App\Models\Administrasi;

use App\Models\MSiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPendanaan extends Model
{
    use HasFactory;
    protected $table = 'pendanaan';
    protected $fillable = ['tipe', 'tipe_pemasukan', 'id_siswa', 'nama', 'detail', 'total', 'saldo'];
    function siswa()
    {
        return $this->belongsTo(MSiswa::class,'id_siswa');
    }
}
