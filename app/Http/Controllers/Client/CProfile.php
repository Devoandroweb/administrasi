<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiswaRequest;
use App\Models\MSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CProfile extends Controller
{
    function index()
    {
        $title = 'Profile Anda';
        $data = MSiswa::find(auth()->guard('siswa')->user()->id_siswa);
        $url = url('client/profile-update');
        return view('pages.client.profile',compact('title', 'data','url'));
    }
    function update(SiswaRequest $request)
    {
        $data = $request->validated();
        $data = $this->credentials($data, $request);
        MSiswa::find(auth()->guard('siswa')->user()->id_siswa)->update($data);
        return redirect(url('client/profile'))->with('msg', 'Sukses Mengubah Siswa');
    }
    function credentials($data, $request)
    {
        $data['username'] = $request->nisn;
        $noTelp = str_replace(" ", "", $request->no_telp);
        $noTelpWithNegara = substr($noTelp, 0, 1);
        if ($noTelpWithNegara == "0") {
            $noTelpWithNegara = "62";
            $noTelp = $noTelpWithNegara . substr($noTelp, 1);
        }

        $data['no_telp'] = $noTelp;
        $requestFile = $request->file('foto');
        if ($requestFile != null) {
            $fileOld = $requestFile->getClientOriginalName(); 
            unlink(public_path() . '/upload/siswa'.$fileOld);
            $nameFile = $this->uploadImage(public_path() . '/upload/siswa', $requestFile);
            $data['foto'] = $nameFile;
        }
        return $data;
    }
}
