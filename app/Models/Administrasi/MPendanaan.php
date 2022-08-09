<?php

namespace App\Models\Administrasi;

use App\Models\MSiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MPendanaan extends Model
{
    use HasFactory;
    protected $table = 'pendanaan';
    protected $fillable = ['tipe', 'tipe_pemasukan', 'id_siswa', 'nama', 'detail', 'total', 'saldo'];
    function siswa()
    {
        return $this->belongsTo(MSiswa::class,'id_siswa');
    }
    public function totalSum($date,$tipe)
    {
        $result = DB::selectOne("SELECT sum(total) as sum_total FROM pendanaan WHERE Date(created_at) = '{$date}' AND tipe = {$tipe}");
        return $result->sum_total;
    }
}
