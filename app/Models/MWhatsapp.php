<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MWhatsapp extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $primaryKey = 'id_whatsapp';
    protected $table = 'm_whatsapp';
    protected $fillable = [
        'no_telp','pesan', 'tipe', 'file','status'
    ];
}
