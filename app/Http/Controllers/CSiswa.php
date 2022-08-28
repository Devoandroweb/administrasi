<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Imports\ImportSiswaPriview;
use App\Imports\SiswaImport;
use App\Models\Administrasi\Siswa;
use App\Models\MJenisAdministrasi;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MTunggakan;
use App\Models\TCicilan;
use App\Models\TSPP;
use App\Traits\Administrasi;
use App\Traits\Helper;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Excel;

class CSiswa extends Controller
{
    use Helper;
    use Uploader;
    use Administrasi;
    
    private $jenisAdmistrasi = null;
    private $spp = null;
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
        try {
            //code...
            $siswa = MSiswa::where('id_siswa', decrypt($id))->with('kelas.jurusan')->first();
            $siswa->{'jk_text'} = $siswa->jenisKelamin();
            $siswa->{'tgl_lhr'} = $siswa->convertTglLahir();
            return response()->json(['status'=>true,'data'=> $siswa],200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=> $th->getMessage()],500);
            //throw $th;
        }
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
    public function destroy($id_siswa)
    {
        try {
            $id = decrypt($id_siswa);
            MSiswa::where('id_siswa',$id)->delete();
            $idAdministrasi = Siswa::where('id_siswa',$id)->pluck('id_administrasi');
            TCicilan::where('tipe',1)->whereIn('id_administrasi',$idAdministrasi)->delete();
            
            $idTunggakan = MTunggakan::where('id_siswa',$id)->pluck('id_tunggakan');
            TCicilan::where('tipe', 2)->whereIn('id_administrasi', $idTunggakan)->delete();

            TSPP::where('id_siswa',$id)->delete();
            Siswa::where('id_siswa',$id)->delete();

            return response()->json(['status' => true, 'msg' => 'Sukses Menghapus Data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    function credentials($data,$request)
    {
        $data['username'] = $request->nisn;
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
            $fileOld = $requestFile->getClientOriginalName(); 
            unlink(public_path() . '/upload/siswa' . $fileOld);
            $nameFile = $this->uploadImage(public_path() . '/upload/siswa', $requestFile);
            $data['foto'] = $nameFile;
        }
        return $data;
    }
    
    function importSiswa()
    {
        return view('pages.siswa.import')->with('title','Import Siswa');
    }
    function importSiswaRead(Request $request)
    {
        // dd($request->all());
        try {
            //code...
            // menangkap file excel
            $file = $request->file('file-import');
            $path = public_path('file_import');
            // membuat nama file unik
            $nama_file = rand() . "-siswa-".$file->getClientOriginalName();
    
            // upload ke folder file_import di dalam folder public
            $file->move($path, $nama_file);
    
            // import data
            $importPriview = new ImportSiswaPriview();
            Excel::import($importPriview, public_path('/file_import/' . $nama_file));
            unlink($path . "\\" . $nama_file);
            // dd($importPriview->getData());
            return response()->json(['status'=>true,'data'=> $importPriview->getData(),'msg'=>$importPriview->message()]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }
    function importSiswaSave(Request $request)
    {
        
        // dd($request->all());
        try {
            //code...
            // menangkap file excel
            $file = $request->file('file-import');
            $path = public_path('file_import');
            // membuat nama file unik
            $nama_file = rand() . "-siswa-" . $file->getClientOriginalName();

            // upload ke folder file_import di dalam folder public
            $file->move($path, $nama_file);
            
            // import data
            $importSiswa = new SiswaImport();
            Excel::import($importSiswa, public_path('/file_import/' . $nama_file));
            unlink($path . "\\" . $nama_file);
            // dd($importSiswa->getData());
            $this->jenisAdmistrasi = MJenisAdministrasi::all();
            $this->createSiswa($importSiswa->getData());
            return response()->json(['status' => true, 'msg'=> 'Sukses Import Siswa','data'=>null]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }
    private function createSiswa($siswas)
    {
        $this->spp = MJenisAdministrasi::where('id', 1)->first();
        $this->spp = $this->spp->biaya;
        // dd($siswas);
        foreach($siswas as $siswa){
            $resultSiswa = MSiswa::create($siswa);
            $this->saveToAdministrasiAndCicilan($resultSiswa->id_siswa,$siswa['administrasi']);
            $spp = $this->spp;
            TSPP::create([
                'id_siswa' => $resultSiswa->id_siswa,
                'januari' => $spp,
                'februari' => $spp,
                'maret' => $spp,
                'april' => $spp,
                'mei' => $spp,
                'juni' => $spp,
                'juli' => $spp,
                'agustus' => $spp,
                'september' => $spp,
                'oktober' => $spp,
                'november' => $spp,
                'desember' => $spp
            ]);
        }
    }
    private function saveToAdministrasiAndCicilan($idSiswa,$dataAdm)
    {
        if(count($dataAdm) != 0){
            foreach($dataAdm as $jenisAdm){
                $admSiswaAfterCreate = Siswa::create([
                    'id_siswa' => $idSiswa,
                    'id_jenis_administrasi'=>$this->searchIdJenisAdmOrCreate($jenisAdm["nama_biaya"]),
                    'nominal' => $jenisAdm["nominal"]
                ]);
                TCicilan::create([
                    'tipe'=>1,
                    'id_administrasi' => $admSiswaAfterCreate->id_administrasi
                ]);
            }
        }else{
            foreach (MJenisAdministrasi::all() as $jenisAdm) {
                if($jenisAdm->id == 1){
                    $biaya = $jenisAdm->biaya * 12;
                }else{
                    $biaya = $jenisAdm->biaya;
                }
                $admSiswaAfterCreate = Siswa::create([
                    'id_siswa' => $idSiswa,
                    'id_jenis_administrasi' => $jenisAdm->id,
                    'nominal' => $biaya
                ]);
                TCicilan::create([
                    'tipe' => 1,
                    'id_administrasi' => $admSiswaAfterCreate->id_administrasi
                ]);
            }
            
        }
    }
    private function searchIdJenisAdmOrCreate($jenisAdm)
    {

        foreach($this->jenisAdmistrasi as $key){
            if(ucwords($key->nama) == ucwords($jenisAdm)){
                return $key->id;
            }
        }
        $resultCreateJAdm = MJenisAdministrasi::create([
            'nama' => $jenisAdm
        ]);
        $this->createRekap($resultCreateJAdm);
        return $resultCreateJAdm->id;
    }
    

}
