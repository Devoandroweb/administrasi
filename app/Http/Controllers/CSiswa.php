<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\Administrasi\Siswa;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Traits\Helper;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CSiswa extends Controller
{
    use Helper;
    use Uploader;
    public function index()
    {
        $url = url('siswa/create');
        $title = "Siswa";
        $data = MSiswa::all();
        return view('pages.siswa.index',compact('url','title','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $url = route('siswa.store');
        $title = "Tambah Siswa";
        $data = null;
        $method = null;
        $kelas = MKelas::with('jurusan')->get();
        // dd($kelas[0]->jurusan->nama);
        return view('pages.siswa.form', compact('url', 'title','data','method', 'kelas'))->with('newNis',$this->newNis());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiswaRequest $request)
    {

        $data = $request->validated();
        $data = $this->credentials($data,$request);
        $afterCreate = MSiswa::create($data);
        // dd($afterCreate->id_siswa);
        $this->createAdministrasi($afterCreate->id_siswa);
        return redirect(url('siswa'))->with('msg','Sukses Menambah Siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MSiswa  $mSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = url('siswa/edit/'.$id);
        $title = "Detail Siswa";
        return view('pages.siswa.form', compact('url', 'title'))->with('data', MSiswa::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MSiswa  $mSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $method = method_field('PUT');
        $url = route('siswa.update',$id);
        $title = "Edit Siswa";
        $kelas = MKelas::with('jurusan')->get();

        return view('pages.siswa.form', compact('url', 'title','method','kelas'))->with('data', MSiswa::find(decrypt($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MSiswa  $mSiswa
     * @return \Illuminate\Http\Response
     */
    public function update($id,SiswaRequest $request)
    {
        $data = $request->validated();
        $data = $this->credentials($data,$request);
        MSiswa::find(decrypt($id))->update($data);
        return redirect(url('siswa'))->with('msg', 'Sukses Mengubah Siswa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MSiswa  $mSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            MSiswa::updateDeleted($id);
            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function credentials($data,$request)
    {
        $data['username'] = $request->nis;
        $data['password'] = Hash::make('12345');
        $noTelp = str_replace(" ", "", $request->no_telp);
        $noTelpWithNegara = substr($noTelp, 0, 1);
        if ($noTelpWithNegara == "0") {
            $noTelpWithNegara = "62";
            $noTelp = $noTelpWithNegara . substr($noTelp, 1);
        }

        $data['no_telp'] = $noTelp;
        $requestFile = $request->file('foto');
        if ($requestFile != null) {
            $nameFile = $this->uploadImage(public_path() . '/upload/siswa', $requestFile);
            $data['foto'] = $nameFile;
        }
        return $data;
    }
    public function createAdministrasi($id_siswa)
    {
        $data = [];
        $jenisAdmistrasi = MJenisAdministrasi::all();
        foreach($jenisAdmistrasi as $key){
           array_push($data, ['id_siswa' => $id_siswa,'id_jenis_administrasi'=>$key->id,'nominal'=>$key->biaya]); 
        } 
        // dd($data);
        Siswa::insert($data);
    }
}
