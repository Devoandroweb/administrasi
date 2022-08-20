<?php

namespace App\Models\Administrasi;

use App\Models\MSiswa;
use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HTransaksi extends Model
{
    use Helper;
    use HasFactory;
    use CreatedUpdatedBy;
    protected $table = 'h_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['kode', 'tanggal', 'id_siswa', 'biaya', 'tunggakan', 'total','terbayar'];
    function siswa()
    {
        return $this->belongsTo(MSiswa::class, 'id_siswa');
    }
    function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    function biaya()
    {
        
        $table = "<table class='table'>";
        $biaya = json_decode($this->biaya);
        if(count($biaya) != 0){
            foreach($biaya as $b){
                $table .= "<tr>";
                $table .= "<td>".$b->nama_biaya;
                $table .= "<td>:";
                $table .= "<td>".$this->ribuan($b->nominal)."<td>";
                $table .= "<tr>";
            }
        }else{
            $table .= '<tr><td>Tidak ada Biaya</td></tr>'; 
        }
        $table .= "</table>";
        $html = "<div class='card mr-4 card-success shadow'>
                    <div class='card-header font-weight-bold'>Tanggungan Sekarang</div>
                    <div class='card-body'>". $table . "</div></div>";
        return $html;

    }
    function tunggakan()
    {
        $table = "<table class='table'>";
        $tunggakan = json_decode($this->tunggakan);
        if (count($tunggakan) != 0) {
            foreach ($tunggakan as $b) {
                $table .= "<tr>";
                $table .= "<td>" . $b->nama_biaya;
                $table .= "<td>:";
                $table .= "<td>" . $this->ribuan($b->nominal) . "<td>";
                $table .= "<tr>";
            }
        } else {
            $table .= '<tr><td>Tidak ada Tunggakan</td></tr>';
        }
        $table .= "</table>";
        $html = "<div class='card mr-4 card-danger shadow'>
                    <div class='card-header font-weight-bold'>Tanggungan Sebelumnya</div>
                    <div class='card-body'>" . $table . "</div></div>";
        return $html;
    }

}
