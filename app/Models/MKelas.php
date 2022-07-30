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
    function jurusan()
    {
        return $this->hasOne(MJurusan::class,'id_jurusan');
    }
}
