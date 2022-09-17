<?php

namespace App\Models;

use App\Models\Administrasi\Siswa;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisAdministrasi extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $table = 'm_jenis_administrasi';
    protected $fillable = [
        'nama', 'biaya','id_kelas'
    ];
    function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
    function kelas()
    {
        return $this->belongsTo(MKelas::class,'id_kelas');
    }

}
