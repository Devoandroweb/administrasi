<?php

namespace App\Http\Controllers;

use App\Models\Administrasi\HTransaksi;
use App\Models\Administrasi\MPendanaan;
use App\Models\Administrasi\Siswa;
use App\Models\MAjaran;
use App\Models\MJabatan;
use App\Models\MJenisAdministrasi;
use App\Models\MJurusan;
use App\Models\MKelas;
use App\Models\MPegawai;
use App\Models\MSiswa;
use App\Models\MWhatsapp;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class CDatatable extends Controller
{
    use Helper;
    protected $bulan = ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"];

    public function siswa_aktif()
    {
        // dd(MPegawai::get());
        return DataTables::eloquent(MSiswa::aktif())
            ->editColumn('jk', function ($row) {
                $result = "-";
                if ($row->jk == "L") {
                    $result = "Laki-laki";
                } elseif ($row->jk == "P") {
                    $result = "Perempuan";
                }
                return $result;
            })
            ->addColumn('action', function ($row) {

                $btn = '';
                if(Auth::user()->role == 1){
                    $btn .= '<a href="' . route('siswa.edit', encrypt($row->id_siswa)) . '" class="text-primary edit mr-2" tooltip="Ubah Biodata Siswa"><i class="fas fa-user-edit"></i></a>';
                    if ($row->id_siswa != 1) {
                        $btn .= '<a href="' . route('siswa.destroy', encrypt($row->id_siswa)). '" class="text-danger delete mr-2" tooltip="Hapus Biodata Siswa"><i class="far fa-trash-alt"></i></a>';
                    }
                }
                $btn .= '<a href="'. url('siswa-show/'.encrypt($row->id_siswa)) .'" class="text-info detail" tooltip="Lihat detail Biodata Siswa" ><i class="fas fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function siswa_nonaktif()
    {
        // dd(MPegawai::get());
        return DataTables::eloquent(MSiswa::nonAktif())
            ->editColumn('jk', function ($row) {
                $result = "-";
                if ($row->jk == "L") {
                    $result = "Laki-laki";
                } elseif ($row->jk == "P") {
                    $result = "Perempuan";
                }
                return $result;
            })
            ->addColumn('action', function ($row) {

                $btn = '';
                if(Auth::user()->role == 1){
                    $btn .= '<a href="' . route('siswa.edit', encrypt($row->id_siswa)) . '" class="text-primary edit mr-2" tooltip="Ubah Biodata Siswa"><i class="fas fa-user-edit"></i></a>';
                    if ($row->id_siswa != 1) {
                        $btn .= '<a href="' . route('siswa.destroy', encrypt($row->id_siswa)). '" class="text-danger delete mr-2" tooltip="Hapus Biodata Siswa"><i class="far fa-trash-alt"></i></a>';
                    }
                }
                $btn .= '<a href="'. url('siswa-show/'.encrypt($row->id_siswa)) .'" class="text-info detail" tooltip="Lihat detail Biodata Siswa" ><i class="fas fa-eye"></i></a>';
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
                $btn .= '<a href="' . route('user.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                if ($row->id != 1) {
                    $btn .= '<a href="' . route('user.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
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
                $btn .= '<a href="' . route('jenis-administrasi.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                if ($row->id != 1) {
                    $btn .= '<a href="' . route('jenis-administrasi.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
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
                $btn .= '<a href="' . route('jurusan.edit', encrypt($row->id_jurusan)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                if ($row->id_jurusan != 1) {
                    $btn .= '<a href="' . route('jurusan.destroy', encrypt($row->id_jurusan)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function kelas()
    {
        $model = MKelas::with('jurusan','siswaAll');
        // dd($model[1]->siswaAll()->where('deleted',0)->get());
        // dd($model[1]);
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->addColumn('jurusan', function ($row) {
                return $row->jurusan->nama;
            })
            ->addColumn('siswa_count', function ($row) {
                $result = '<a href="#" class="badge badge-info">'. $row->siswaAll()->where('deleted',0)->get()->count().'</a>';
                return $result;
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="' . route('kelas.edit', encrypt($row->id_kelas)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
                // if ($row->id_kelas != 1) {
                //     $btn .= '<a href="' . route('kelas.destroy', encrypt($row->id_kelas)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                // }
                return $btn;
            })
            ->rawColumns(['action', 'jurusan', 'siswa_count'])
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
                          <input type="radio" name="status" value="1" data-url="'.url('aktif-ajaran/'.encrypt($row->id)).'" class="custom-switch-input" '.$status.' disabled>
                          <span class="custom-switch-indicator"></span>
                        </label>';
            })
            // ->addColumn('action', function ($row) {
            //     $btn = '';
            //     if ($row->id != 1) {
            //         $btn .= '<a href="' . route('ajaran.destroy', encrypt($row->id)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
            //     }
            //     $btn .= '<a href="' . route('ajaran.edit', encrypt($row->id)) . '" class="text-primary edit"><i class="fas fa-user-edit"></i></a>';
            //     return $btn;
            // })
            ->rawColumns(['status_convert'])
            ->addIndexColumn()
            ->toJson();
    }
    public function administrasi()
    {
        $kelas = (isset($_GET['kelas']) ? $_GET['kelas'] : -1);
        if($kelas == 0){
            $model = MSiswa::nonAktif();
        }else{
            $model = MSiswa::aktif();
            if($kelas != -1){
                $model = $model->where('id_kelas', $kelas);
            }
        }
        $model = $model->with('admSiswa', 'kelas','spp');
        // dd($model[3]->kelas->jurusan);
        // dd($model->get());
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->addColumn('kelas', function ($row) {
                if($row->id_kelas != 0){
                    return $row->kelas->nama." ". $row->kelas->jurusan->nama;
                }
                return "<i class='text-danger'>Alumni</i>";
            })
            ->addColumn('biaya', function ($row) {
                $html = '<div class="row">'; //row
                $html .= '<div class="col">'; // col
                
                $html .= '<div class="mb-2 font-weight-bold text-success">Biaya</div>';
                $html .= "<table class='border w-100'>";
                foreach($row->admSiswa as $key){
                    $html .= "<tr>"; 
                        $html .= "<td class='font-weight-bold'>".$key->jenisAdministrasi->nama; 
                        $html .= "<td>:</td>";
                        if($key->nominal != 0){
                            $html .= "<td class='text-right'>".$this->ribuan($key->nominal); 
                        }else{
                            $html .= "<td class='text-right text-success'> Lunas"; 
                        }
                    $html .= "</tr>"; 
                }
                $html .= "</table>";
                $html .= '</div>'; //end col

                $html .= '<div class="col">'; // col
                $html .= '<div class="mb-2 font-weight-bold text-success">Detail SPP</div>';
                $html .= "<table class='border w-100'>";
                // dd($this->bulan);
                
                for ($i = 0; $i < count($this->bulan); $i++) {
                    $html .= "<tr>";
                    $html .= "<td class='font-weight-bold text-capitalize'>" . $this->bulan[$i];
                    $html .= "<td>:</td>";
                    if ($row->spp->{$this->bulan[$i]} != 0) {
                        $html .= "<td class='text-right'>" . $this->ribuan($row->spp->{$this->bulan[$i]});
                    } else {
                        $html .= "<td class='text-right text-success'> Lunas";
                    }
                    $html .= "</tr>";
                }
                $html .= "</table>";
                $html .= '</div>'; //end col
                $html .= '</div>'; // end row
                if(count($row->admSiswa) == 0){
                    $html = "<div class='text-danger'>Biaya tidak ada</div>";
                }
                return $html;
            })
            ->addColumn('tunggakan', function ($row) {
                
                $btn = '<a href="' . url('administrasi-siswa-tunggakan/'. encrypt($row->id_siswa)) . '" class="text-primary mr-2" tooltip="Klik untuk melihat Detail Tunggakan"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . url('administrasi-siswa-cicilan/'. encrypt($row->id_siswa)) . '" class="text-warning mr-2" tooltip="Klik untuk melihat Cicilan Tunggakan"><i class="fas fa-coins"></i></a>';
                $btn .= '<a href="' . url('administrasi-siswa-cetak-tunggakan/'. encrypt($row->id_siswa)) . '" class="text-info" tooltip="Download Tunggakan"><i class="fas fa-file-download"></i></a>';
                return $btn;
            })
            ->rawColumns(['biaya','kelas', 'tunggakan'])
            ->addIndexColumn()
            ->toJson();
    }
    public function pendanaan()
    {
        $model = MPendanaan::with('siswa');
        // $biaya = json_decode($model[0]->detail);
        // dd($biaya);
        
        // dd($model[0]->siswa);
        
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->addColumn('nis_convert', function ($row) {
                if($row->tipe_pemasukan == 1){
                    if($row->siswa != null){
                        return $row->siswa->nisn;
                    }else{
                        return '<i class="text-danger">Siswa tidak ada atau telah di hapus</i>';
                    }
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
                    if($row->siswa != null){
                        $nama = $row->siswa->nama;
                    }else{
                        $nama = "-";
                    }
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
            ->rawColumns(['detail','status', 'nis_convert'])
            ->addIndexColumn()
            ->toJson();
    }
    public function whatsapp()
    {
        $model = MWhatsapp::query();
        // dd(Auth::user()->id);
        return DataTables::eloquent($model)

            ->addColumn('no_telp_convert', function ($row) {
                
                return '<i class="fab fa-whatsapp"></i> '.$row->no_telp;
            })
            ->addColumn('pesan_convert', function ($row) {
                if($row->tipe == 2){
                    return "<a href='". url('upload/whatsapp/' . $row->file)."' target='_blank' class='text-info'>".$row->file."</a>";
                }
                return $row->pesan;
            })
            ->addColumn('tipe_convert', function ($row) {
                if($row->tipe == 1){
                    return "<span class='text-success'>Text</span>";
                }else{
                    return "<span class='text-info'>File</span>";
                }
                return "-";
                
            })
            ->addColumn('status_convert', function ($row) {
                if ($row->status == 1) {
                    return "<span class='text-success'><i class='far fa-check-circle'></i> Success</span>";
                } else {
                    return "<span class='text-danger'><i class='far fa-times-circle'></i> Failed</span>";
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="' . route('whatsapp.destroy', encrypt($row->id_whatsapp)) . '" class="text-danger delete mr-2"><i class="far fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'pesan_convert', 'tipe_convert', 'status_convert', 'no_telp_convert'])
            ->addIndexColumn()
            ->toJson();
    }
    function htransaksi()
    {
        $model = HTransaksi::with('createdBy','siswa');

        // dd(Auth::user()->id);
        return DataTables::eloquent($model)
            ->editColumn('tanggal', function ($row) {
                return $this->convertDate($row->tanggal,true,false);
            })
            ->editColumn('total', function ($row) {
                return $this->ribuan($row->total);
            })
            ->editColumn('terbayar', function ($row) {
                return $this->ribuan($row->terbayar);
            })
            ->addColumn('biaya_convert', function ($row) {
                return $row->biaya();
            })
            ->addColumn('tunggakan_convert', function ($row) {
                return $row->tunggakan();
            })
            ->addColumn('tanggal_convert', function ($row) {
                return $this->convertDate($row->tanggal,true,false);
            })
            ->addColumn('penerima', function ($row) {
                return $row->createdBy->name;
            })->addColumn('penyetor', function ($row) {
                if($row->siswa != null){
                    return $row->siswa->nama;
                }
                return "-";
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="' . url('pembayaran-cetak-struk/'. encrypt($row->id_transaksi)) . '" target="_blank" tooltip="Cetak Struk" class="text-info delete mr-2"><i class="fas fa-print"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','biaya_convert','tunggakan_convert','tanggal_convert', 'penerima', 'penyetor'])
            ->addIndexColumn()
            ->toJson();
    }
}
