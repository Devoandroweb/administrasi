<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCicilan extends Model
{
    use HasFactory;
    protected $table = 't_cicilan';
    protected $primaryKey = 'id_cicilan';
    public $timestamps = false;
    protected $fillable = [
        "tipe",
        "id_administrasi",
        "deskripsi",
        "updated_at",
    ];
    static function tipeNow()
    {
        return self::where('tipe', 1);
    }
    static function tipeTunggakan()
    {
        return self::where('tipe', 2);
    }
}
