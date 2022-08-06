<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CHTransaksi extends Controller
{
    function cetak_struk($id)
    {
        return view('pages.pembayaran.cetak_struk')->with('id',$id);
    }
}
