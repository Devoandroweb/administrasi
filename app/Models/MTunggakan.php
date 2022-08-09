<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTunggakan extends Model
{
    use HasFactory;
    protected $table = 'tunggakan';
    protected $primaryKey = 'id_tunggakan';
    public $timestamps = false;
    protected $fillable = ['id_siswa', 'nama_tunggakan', 'nominal', 'ajaran'];
    function siswa()
    {
        return $this->belongsTo(MSiswa::class, 'id_siswa');
    }
}
