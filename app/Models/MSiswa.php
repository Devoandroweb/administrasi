<?php

namespace App\Models;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\Pendanaan;
use App\Models\Administrasi\Siswa;
use App\Traits\CreatedUpdatedBy;
use App\Traits\Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use CreatedUpdatedBy;
    use Helper;
    protected $table = 'm_siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
        'username','password','nisn','nama','jk','no_telp','alamat','foto','id_kelas','deleted','tempat_lahir','tgl_lahir','status'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'password'
    ];
    public static function aktif()
    {
        return parent::withDeleted()->where('status',1);
    }
    public static function nonAktif()
    {
        return parent::withDeleted()->where('status',0);
    }
    function generatePhotos($class)
    {
        $img = '<img class="'.$class.'" src="'.url('img/').$this->foto.'" alt="'.$this->nama.'">';
        return $img;
    }
    function jenisKelamin()
    {
        return $this->chooseGender($this->jk);
    }
    function convertTglLahir()
    {
        return $this->convertDate($this->tgl_lahir,false,false);
    }
    public static function withDeleted()
    {
        return self::where('deleted', 0);
    }
    public static function updateDeleted($id)
    {
        return self::find(decrypt($id))->delete();
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
    public function spp()
    {
        return $this->belongsTo(TSPP::class, 'id_siswa');
    }
    public function pendanaan()
    {
        return $this->hasOne(Pendanaan::class,'id_siswa');
    }
    public function htransaksi()
    {
        return $this->hasOne(HTransaksi::class,'id_siswa');
    }
    public function namaKelas()
    {
        if($this->id_kelas != 0){
            return $this->kelas->nama."-".$this->kelas->jurusan->nama;
        }
        return "Alumni";
    }
}
