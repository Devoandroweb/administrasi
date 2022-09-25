<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKelas extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $primaryKey = 'id_kelas';
    protected $table = 'm_kelas';
    protected $fillable = [
        'nama', 'id_jurusan'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    function jurusan()
    {
        return $this->belongsTo(MJurusan::class,'id_jurusan');
    }
    function siswa()
    {
        return $this->hasOne(MSiswa::class,'id_siswa');
    }
    function siswaAll()
    {
        return $this->hasMany(MSiswa::class,'id_kelas');
    }
    public function namaKelas()
    {
        return $this->nama . "-" . $this->jurusan->nama;
    }
    function jenisBiaya()
    {
        return $this->hasOne(MJenisAdministrasi::class,'id_kelas');
    
    }
    public static function withNoUrut()
    {
        return self::orderBy('no_urut','asc');
    }
}
