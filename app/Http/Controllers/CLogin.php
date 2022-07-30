<?php

namespace App\Http\Controllers;

use App\Models\MAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CLogin extends Controller
{
    public function admin()
    {
        return view('login')->with('title','Login');
    }
    public function authAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials['deleted'] = 1;
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            //simpan tahun ajaran
            $ajaran = MAjaran::where('status',1)->first();
            $_SESI_AJARAN = [];
            if($ajaran != null){
                $_SESI_AJARAN['tahun_awal'] = $ajaran->tahun_awal; 
                $_SESI_AJARAN['tahun_akhir'] = $ajaran->tahun_akhir;
            }
            Session::put($_SESI_AJARAN);
            return redirect(url('/dashboard'));
        }

        return back()->with('msg','Email atau Password Salah');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
