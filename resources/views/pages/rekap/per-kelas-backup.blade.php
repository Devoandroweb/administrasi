@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')
@push('style')
<style>
     table{
        border-collapse: collapse;
        border: 1px solid black;
    }
    table th{
        text-transform: uppercase;
    }
    table th,td{
        padding: 0.2rem 0.5rem !important;
        border: 1px solid black;
        height: 30px !important;

    }
</style>
@endpush
<section class="section">
    <div class="section-header">
    <h1>Rekapitulasi</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('kelas') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Rekapitulasi Administrasi Siswa per Kelas</h4>
            {{-- <div class="card-header-action">
                <a href="#" class="btn btn-primary" id="btn-add-data">
                Tambah Kelas
                </a>
            </div> --}}
            </div>
            <div class="card-body">
            <div class="loader-line form-loader d-none mb-2"></div>
            <div class="table-responsive">
               {{-- moderation --}}
                <?php
                    use App\Models\MJenisAdministrasi;
                    use App\Models\MKelas;
                    use App\Models\MRekap;
                    use App\Traits\Helper;
                    $mJenisAdm = MJenisAdministrasi::paginate(10);
                    $mKelas = MKelas::with('jurusan')->orderBy('no_urut','asc')->get();
                    function cariRekap($_idJenisAdm,$_idKelas)
                    {
                        $mRekap = MRekap::all();
                        foreach ($mRekap as $key) {
                            if($key->id_jenis_administrasi == $_idJenisAdm && $key->id_kelas == $_idKelas){
                                return $key->total;
                            }
                        }
                        return 0;
                    }
                    function cariAdmTotal($id_jenis_adm,$id_kelas)
                    {
                        $data = DB::selectOne("SELECT m_siswa.id_kelas, SUM(administrasi.nominal) as nominal_adm FROM administrasi 
                                    INNER JOIN m_siswa ON m_siswa.id_siswa = administrasi.id_siswa 
                                    INNER JOIN m_kelas ON m_siswa.id_kelas = m_kelas.id_kelas 
                                    WHERE id_jenis_administrasi = {$id_jenis_adm} AND m_siswa.id_kelas = {$id_kelas} GROUP BY m_siswa.id_kelas");
                        if($data == null){
                            return 0;
                        }
                        return $data->nominal_adm;
                    }
                ?>
                <table id="data" class="table" style="color:black;" width="100%">
                    <thead>
                    <tr style="">
                        <th  rowspan="2" style="width:150px;vertical-align: center;text-align:center;border: 1px solid black;"><b>Nama Pembayaran</b> </th>
                        <th  rowspan="2" style="vertical-align: center;text-align:center;border: 1px solid black;"><b>Jenis</b> </th>
                        <th  colspan="{{$mKelas->count()}}" style="text-align:center;border: 1px solid black;"><b>Kelas</b></th>
                        <th style="width:100px;vertical-align: center;text-align:center;border: 1px solid black;" rowspan="2"><b>Jumlah</b></th>
                    </tr>
                    <tr style="">
                        @foreach ($mKelas as $item)
                            <th style="width:90px;font-weight:bold;text-align:center;border: 1px solid black;">{{$item->nama." ".$item->jurusan->nama}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalInKelasTanggungan = [];
                            $totalInKelasKurang = [];
                            $totalInKelasTerbayar = [];
                            foreach ($mKelas as $key) {
                                $totalInKelasTanggungan[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                                $totalInKelasKurang[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                                $totalInKelasTerbayar[strtolower($key->nama."_".$key->jurusan->nama)] = 0; 
                            }
                            
                        @endphp
                        @foreach ($mJenisAdm as $jenisAdm)
                            {{-- Tanggungan --}}
                            <tr>
                                <td rowspan="3" style="vertical-align: center;border: 1px solid black;">{{$jenisAdm->nama}}</td>
                                <td style="border: 1px solid black;">Tanggungan</td>
                                @php
                                    $totalTanggungan = 0;
                                @endphp 
                                @foreach ($mKelas as $item)
                                    @php
                                        $nominalTanggungan = cariAdmTotal($jenisAdm->id,$item->id_kelas) + cariRekap($jenisAdm->id,$item->id_kelas);
                                        $totalTanggungan = $totalTanggungan + $nominalTanggungan;
                                        $totalInKelasTanggungan[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasTanggungan[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalTanggungan;
                                        
                                    @endphp
                                    <td style="text-align: right;border: 1px solid black;">{{Helper::ribuan($nominalTanggungan)}}</td>
                                @endforeach
                                <td style="text-align: right;border: 1px solid black;">{{Helper::ribuan($totalTanggungan)}}</td>
                            </tr>
                            {{-- yg sudah di bayar --}}
                            <tr>
                                @php
                                    $totalTerbayar = 0;
                                @endphp
                                <td style="border: 1px solid black;">Terbayar</td>
                                @foreach ($mKelas as $item)
                                    @php
                                        $nominalTerbayar = cariRekap($jenisAdm->id,$item->id_kelas);
                                        $totalTerbayar = $totalTerbayar + $nominalTerbayar;
                                        $totalInKelasTerbayar[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasTerbayar[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalTerbayar;
                                    @endphp
                                    <td style="text-align: right;border: 1px solid black;">{{
                                        Helper::ribuan($nominalTerbayar);
                                    }}</td>
                                @endforeach
                                <td style="text-align: right;border: 1px solid black;">{{Helper::ribuan($totalTerbayar)}}</td>
                            </tr>
                            {{-- Kurang --}}
                            <tr>
                                @php
                                    $totalKurang = 0;
                                @endphp
                                <td style="border: 1px solid black;">Kurang</td>
                                @foreach ($mKelas as $item)
                                    @php
                                        $nominalKurang = cariAdmTotal($jenisAdm->id,$item->id_kelas);
                                        $totalKurang = $totalKurang + $nominalKurang;
                                        $totalInKelasKurang[strtolower($item->nama."_".$item->jurusan->nama)] = $totalInKelasKurang[strtolower($item->nama."_".$item->jurusan->nama)] + $nominalKurang;
                                    @endphp
                                    <td style="text-align: right;border: 1px solid black;">{{
                                            Helper::ribuan($nominalKurang)
                                        }}</td>
                                @endforeach
                                <td style="text-align: right;border: 1px solid black;">{{Helper::ribuan($totalKurang)}}</td>
                            </tr>
                            
                        @endforeach
                        @php
                            $jumlahInKelasTanggungan = 0;
                            $jumlahInKelasKurang = 0;
                            $jumlahInKelasTerbayar = 0;

                        @endphp
                        <tr style="font-weight: bold;">
                            <td rowspan="3" style="vertical-align: center;border: 1px solid black;"><b>Total</b></td>
                            <td style="border: 1px solid black;"><b>Tanggungan</b></td>
                            @foreach ($mKelas as $kelas)
                            @php
                                $jumlah = $totalInKelasTanggungan[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                                $jumlahInKelasTanggungan = $jumlahInKelasTanggungan + $jumlah;
                            @endphp
                                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlah)}}</td>
                            @endforeach
                            <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlahInKelasTanggungan)}}</td>
                        </tr>
                        
                        <tr>
                            <td style="border: 1px solid black;"><b>Terbayar</b></td>
                            @foreach ($mKelas as $kelas)
                            @php
                                $jumlah = $totalInKelasTerbayar[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                                $jumlahInKelasTerbayar = $jumlahInKelasTerbayar + $jumlah;
                            @endphp
                                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlah)}}</td>
                            @endforeach
                            <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlahInKelasTerbayar)}}</td>

                        </tr>
                        <tr>
                            <td style="border: 1px solid black;"><b>Kurang</b></td>
                            @foreach ($mKelas as $kelas)
                            @php
                                $jumlah = $totalInKelasKurang[strtolower($kelas->nama."_".$kelas->jurusan->nama)];
                                $jumlahInKelasKurang = $jumlahInKelasKurang + $jumlah;
                            @endphp
                                <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlah)}}</td>
                            @endforeach
                            <td style="text-align: right;font-weight: bold;border: 1px solid black;">{{Helper::ribuan($jumlahInKelasKurang)}}</td>

                        </tr>
                    </tbody>
                </table>
            {{-- end moderation --}}
            {{ $mJenisAdm->links('vendor.paginate') }}

            </div>
            </div>
        </div>
</section>

@endsection

