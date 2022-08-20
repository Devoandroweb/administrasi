<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRekapTunggakan extends Model
{
    use HasFactory;
    protected $table = 'rekap_tunggakan';
    protected $primaryKey = 'id_rekap_tunggakan';
    public $timestamps = false;
    protected $fillable = ['nama_tunggakan', 'total'];
}
