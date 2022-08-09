<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CLaporan extends Controller
{
    function index()
    {
        return view('pages.report.index')->with('title','Laporan');
    }
}
