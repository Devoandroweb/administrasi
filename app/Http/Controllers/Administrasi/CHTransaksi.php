<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CHTransaksi extends Controller
{
    function index()
    {
        return view('pages.htransaksi.index')->with('title', 'Riwayat Transaksi');
    }
    function cetak_struk($id)
    {
        return view('pages.pembayaran.cetak_struk')->with('id',decrypt($id));
    }
}
