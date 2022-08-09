<?php

namespace App\Models;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Pendanaan;
use App\Models\Administrasi\Siswa;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use CreatedUpdatedBy;
    protected $table = 'm_siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
        'username','password','nis','nama','jk','no_telp','alamat','foto','id_kelas','deleted','tempat_lahir','tgl_lahir'
    ];
    function generatePhotos($class)
    {
        $img = '<img class="'.$class.'" src="'.url('img/').$this->foto.'" alt="'.$this->nama.'">';
        return $img;
    }
    public static function withDeleted()
    {
        return self::where('deleted', 1);
    }
    public static function updateDeleted($id)
    {
        return self::find(decrypt($id))->update(['deleted' => 0]);
    }
    public function admSiswa()
    {
        return $this->hasMany(Siswa::class,'id_siswa');
    }
    public function tunggakan()
    {
        return $this->hasMany(MTunggakan::class,'id_siswa');
    }
    public function kelas()
    {
        return $this->belongsTo(MKelas::class, 'id_kelas');
    }
    public function pendanaan()
    {
        return $this->hasOne(Pendanaan::class,'id_siswa');
    }
    public function htransaksi()
    {
        return $this->hasOne(HTransaksi::class,'id_siswa');
    }
}
