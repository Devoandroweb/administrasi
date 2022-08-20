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
    function totalSpp()
    {
        $total = 0;
        $total += $this->januari;
        $total += $this->februari;
        $total += $this->maret;
        $total += $this->april;
        $total += $this->mei;
        $total += $this->juni;
        $total += $this->juli;
        $total += $this->agustus;
        $total += $this->september;
        $total += $this->oktober;
        $total += $this->november;
        $total += $this->desember;
        return $total;
    }
}
