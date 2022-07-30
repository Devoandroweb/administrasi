<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\MSiswa;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CSiswa extends Controller
{
    use Helper;
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
        return view('pages.siswa.form', compact('url', 'title','data','method'))->with('newNis',$this->newNis());
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
        // dd($request->all());
        $data['username'] = $request->nip;
        $data['password'] = Hash::make('12345');
        $data['no_telp'] = str_replace(" ","",$request->no_telp);
        $data['id_jabatan'] = 1; // ini nanti di sesuaikan
        // dd($data);
        MSiswa::create($data);
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
        return view('pages.siswa.form', compact('url', 'title','method'))->with('data', MSiswa::find(decrypt($id)));
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
        MSiswa::find(decrypt($id))->update($request->safe()->except('_method','_token'));
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
    
}
