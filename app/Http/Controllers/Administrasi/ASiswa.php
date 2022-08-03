<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ASiswa extends Controller
{
    function __invoke()
    {
        $title = "Siswa";
        return view('pages.administrasi.siswa.index', compact('title'));
    }
}
