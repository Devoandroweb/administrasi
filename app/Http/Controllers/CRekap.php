<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CRekap extends Controller
{
    function rekap()
    {
        return view('pages.report.rekap');
    }
    function rekapTanggunganSebelumnya()
    {
        return view('pages.report.rekap-tanggungan-sebelumnya');
    }
}
