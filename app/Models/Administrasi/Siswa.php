<?php

namespace App\Models\Administrasi;

use App\Models\MJenisAdministrasi;
use App\Models\MSiswa;
use App\Models\TCicilan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'administrasi';
    protected $primaryKey = 'id_administrasi';
    public $timestamps = false;
    protected $fillable = ['id_siswa', 'id_jenis_administrasi','nominal'];
  
    function siswa()
    {
        return $this->belongsTo(MSiswa::class,'id_siswa');
    }
    function jenisAdministrasi()
    {
        return $this->belongsTo(MJenisAdministrasi::class,'id_jenis_administrasi');
    }
    function cicilan()
    {
        return $this->hasOne(TCicilan::class,'id_administrasi');
    }
}
