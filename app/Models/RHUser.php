<?php

namespace App\Models;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RHUser extends Model
{
    use HasFactory;
    use Helper;
    protected $table = 'h_user';
    protected $primaryKey = 'id_h_user';
    public $timestamps = false;
    protected $fillable = ['id_user','date_login'];
    function user()
    {
        return $this->hasOne(User::class,'id','id_user');
    }
    function lastTimeLogin($id_user)
    {
        if($id_user == Auth::user()->id){
            return 'Now';
        }
        return $this->dateDifference($this->getAttribute('date_login'),date('Y-m-d H:i:s'), '%dh %hj %im');
    }
}
