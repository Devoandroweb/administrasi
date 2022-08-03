<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\MPendanaan;
use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MJabatan;
use App\Models\MJenisAdministrasi;
use App\Models\MJurusan;
use App\Models\MKelas;
use App\Models\MPegawai;
use App\Models\MSiswa;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class CDatatable extends Controller
{
    use Helper;
    public function siswa()
    {
        // dd(MPegawai::get());
        return DataTables::eloquent(MSiswa::withDeleted())
            ->editColumn('jk', function ($row) {
                $result = "-";
                if ($row->jk == 1) {
                    $result = "Laki-laki";
                } elseif ($row->jk == 2) {
                    $result = "Perempuan";
                }
                return $result;
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id_siswa != 1) {
                    $btn .= '<a href="' . route('siswa.destroy', encrypt($row->id_siswa)). '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('siswa.edit', encrypt($row->id_siswa)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function user()
    {
        $model = User::withDeleted()->where('id','!=',Auth::user()->id);
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->addColumn('role_convert', function ($row) {
                return $this->convertRole($row->role);
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id != 1) {
                    $btn .= '<a href="' . route('user.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('user.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'role_convert'])
            ->addIndexColumn()
            ->toJson();
    }
    public function jenis_administrasi()
    {
        $model = MJenisAdministrasi::query();
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->editColumn('biaya', function ($row) {
                return $this->ribuan($row->biaya);
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id != 1) {
                    $btn .= '<a href="' . route('jenis-administrasi.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('jenis-administrasi.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function jurusan()
    {
        $model = MJurusan::query();
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id_jurusan != 1) {
                    $btn .= '<a href="' . route('jurusan.destroy', encrypt($row->id_jurusan)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('jurusan.edit', encrypt($row->id_jurusan)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function kelas()
    {
        $model = MKelas::with('jurusan');
        // dd($model[0]->nama);
        // dd($model[1]);
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->addColumn('jurusan', function ($row) {
                return $row->jurusan->nama;
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id_kelas != 1) {
                    $btn .= '<a href="' . route('kelas.destroy', encrypt($row->id_kelas)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('kelas.edit', encrypt($row->id_kelas)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'jurusan'])
            ->addIndexColumn()
            ->toJson();
    }
    public function ajaran()
    {
        $model = MAjaran::query();
        
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->addColumn('status_convert', function ($row) {
                $status = '';
                if($row->status == 1){
                    $status = 'checked';
                }
                return '<label class="custom-switch">
                          <input type="radio" name="status" value="1" data-url="'.url('aktif-ajaran/'.encrypt($row->id)).'" class="custom-switch-input" '.$status.'>
                          <span class="custom-switch-indicator"></span>
                        </label>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id != 1) {
                    $btn .= '<a href="' . route('ajaran.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('ajaran.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'status_convert'])
            ->addIndexColumn()
            ->toJson();
    }
    public function administrasi()
    {
        $model = MSiswa::with('admSiswa','kelas');
        // dd($model[3]->kelas->jurusan);
        
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->addColumn('kelas', function ($row) {
                return $row->kelas->nama." ". $row->kelas->jurusan->nama;
            })
            ->addColumn('biaya', function ($row) {
                $html = '<div class="mb-2 font-weight-bold text-success">Biaya</div>';
                $html .= "<table class='border'>";
                foreach($row->admSiswa as $key){
                    $html .= "<tr>"; 
                        $html .= "<td class='font-weight-bold'>".$key->jenisAdministrasi->nama; 
                        $html .= "<td>:</td>";
                        $html .= "<td class='text-right'>".$this->ribuan($key->jenisAdministrasi->biaya); 
                    $html .= "</tr>"; 
                }
                $html .= "</table>";
                if(count($row->admSiswa) == 0){
                    $html = "<div class='text-danger'>Biaya tidak ada</div>";
                }
                return $html;
            })
            ->rawColumns(['biaya','kelas'])
            ->addIndexColumn()
            ->toJson();
    }
    public function pendanaan()
    {
        $model = MPendanaan::with('siswa');
        // $biaya = json_decode($model[0]->detail);
        // dd($biaya);
        
        // dd($model[3]->kelas->jurusan);
        
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->editColumn('nis', function ($row) {
                if($row->tipe_pemasukan == 1){
                    return $row->siswa->nis;
                }
                return '-';
            })
            ->editColumn('total', function ($row) {
                return $this->ribuan($row->total);
            })
            ->editColumn('saldo', function ($row) {
                return $this->ribuan($row->saldo);
            })
            ->editColumn('nama', function ($row) {
                $nama = "";
                if($row->tipe_pemasukan == 1){
                    $nama = $row->siswa->nama;
                }else{
                    $nama = $row->nama;
                }
                return $nama;
            })
            ->addColumn('detail', function ($row) {
                $html = '<div class="mb-2 font-weight-bold text-success">Detail Pembayaran</div>';
                $html .= "<table class='border'>";
                $biaya = json_decode($row->detail);

                foreach($biaya as $key){
                    $html .= "<tr>"; 
                        $html .= "<td class='font-weight-bold'>".$key->nama_biaya; 
                        $html .= "<td>:</td>";
                        $html .= "<td class='text-right'>".$this->ribuan($key->nominal); 
                    $html .= "</tr>"; 
                }
                $html .= "</table>";
                
                return $html;
            })
            ->addColumn('status', function ($row)
            {
                $total = $this->ribuan($row->total);
                if($row->tipe == 1){
                    return '<span class="text-success">+ Rp. '.$total.'</span>';
                }
                return '<span class="text-danger">- Rp. ' . $total . '</span>';
            })
            ->editColumn('created_at', function ($row) {
            
                return $this->convertDate($row->created_at,true,false);
            })
            ->rawColumns(['detail','status'])
            ->addIndexColumn()
            ->toJson();
    }
}
