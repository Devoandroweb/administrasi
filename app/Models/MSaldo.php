<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSaldo extends Model
{
    use HasFactory;
    protected $table = 'm_saldo';
    public $timestamps = false;
    protected $fillable = ['saldo'];
}
