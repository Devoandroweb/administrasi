<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJurusan extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $primaryKey = 'id_jurusan';
    protected $table = 'm_jurusan';
    protected $fillable = ['nama'];
    public function kelas()
    {
        return $this->hasOne(MKelas::class,);
    }
}
