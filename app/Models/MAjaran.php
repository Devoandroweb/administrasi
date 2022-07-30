<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAjaran extends Model
{
    use HasFactory;
    // use CreatedUpdatedBy;
    protected $table = 'm_ajaran';
    public $timestamps = false;
    protected $fillable = ['tahun_awal','tahun_akhir','status'];
    function updatedStatus()
    {
        return $this->update(['status'=>0]);
    }
}
