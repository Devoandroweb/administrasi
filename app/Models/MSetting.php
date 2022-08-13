<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSetting extends Model
{
    use HasFactory;
    protected $table = "m_setting";
    protected $primaryKey = "id_setting";
    public $timestamps = false;
}
