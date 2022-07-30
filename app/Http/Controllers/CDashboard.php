<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CDashboard extends Controller
{
    public function index()
    {
        // dd(Session::get('tahun_awal'));
        return view('pages.dashboard.index')->with('title','Dashboard');
    }
}
