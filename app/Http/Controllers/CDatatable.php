<?php

namespace App\Http\Controllers;

use App\Models\MAjaran;
use App\Models\MJabatan;
use App\Models\MJenisAdministrasi;
use App\Models\MJurusan;
use App\Models\MKelas;
use App\Models\MPegawai;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class CDatatable extends Controller
{
    use Helper;
    public function pegawai()
    {
        // dd(MPegawai::get());
        return DataTables::eloquent(MPegawai::withDeleted())
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
                if ($row->id_pegawai != 1) {
                    $btn .= '<a href="' . route('pegawai.destroy', encrypt($row->id_pegawai)). '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('pegawai.edit', encrypt($row->id_pegawai)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
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
        
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->addColumn('jurusan', function ($row) {
                return $row->jurusan->nama;
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->id_jurusan != 1) {
                    $btn .= '<a href="' . route('jurusan.destroy', encrypt($row->id_jurusan)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                $btn .= '<a href="' . route('jurusan.edit', encrypt($row->id_jurusan)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','jurusan'])
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
}
