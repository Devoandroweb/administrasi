<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRekap extends Model
{
    use HasFactory;
    protected $table = 'm_rekap';
    protected $primaryKey = 'id_rekap';
    public $timestamps = false;
    protected $fillable = ['id_jenis_administrasi','id_kelas','total'];
}
