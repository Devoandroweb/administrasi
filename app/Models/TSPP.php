<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TSPP extends Model
{
    use HasFactory;
    protected $table = 't_spp';
    protected $primaryKey = 'id_spp';
    public $timestamps = false;
    protected $fillable = ["id_siswa","januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember", "updated_at"];
}
