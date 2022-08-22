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
        border: 1px solid black !important;
        height: 30px !important;
    }
</style>
@endpush
@php
    use App\Traits\Helper;

    function terbayar($terbayar,$idsiswa,$tipe)
    {
        $total = 0;
        foreach ($terbayar as $ter) {
            if($ter->id_siswa == $idsiswa){
                if($tipe == 1){ // biaya
                    $biaya = json_decode($ter->biaya);
                    foreach ($biaya as $biay) {
                        $total += (int)$biay->nominal;
                    }
                }elseif($tipe == 2){ // tunggakan
                    $tunggakan = json_decode($ter->tunggakan);
                    foreach ($tunggakan as $tgg) {
                        $total += (int)$tgg->nominal;
                    }
                }
            }
        }
        return [Helper::ribuan($total),$total];
    }
    function kurangAdm($administrasi,$idsiswa)
    {
        $total = 0;
        foreach ($administrasi as $adm) {
            if($adm->id_siswa == $idsiswa){
                $total += $adm->nominal;
            }
        }
        return  [Helper::ribuan($total),$total];
    }
    function kurangTgg($tunggakan,$idsiswa)
    {
        $total = 0;
        foreach ($tunggakan as $tgg) {
            if($idsiswa == $tgg->id_siswa){
                $total += $tgg->nominal;
            }
        }
        return  [Helper::ribuan($total),$total];
    }
    function cariKelas($kelas,$id)
    {
        if($id == 0){
            return 'ALUMNI';
        }else{
            foreach ($kelas as $key) {
                if($key->id_kelas == $id){
                    return $key->namaKelas();
                }
            }
        }
        return null;
    }
@endphp
<section class="section">
    <div class="section-header">
    <h1>Rekapitulasi</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('kelas') }}
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <h4>Rekapitulasi Administrasi Siswa per Siswa</h4>
            <div class="card-header-action">
                <a href="{{url('export/rekap-per-siswa')}}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel"></i> Export
                </a>
            </div>
            <div class="card-header-action dropdown ">
                @if(cariKelas($kelas,$k) != null)
                <a href="#" data-toggle="dropdown" class="btn btn-danger filter-kelas dropdown-toggle mr-2" aria-expanded="false"><i class="fas fa-filter"></i> Filter : {{cariKelas($kelas,$k)}}</a>
                @else
                <a href="#" data-toggle="dropdown" class="btn btn-danger filter-kelas dropdown-toggle mr-2" aria-expanded="false"><i class="fas fa-filter"></i> Pilih Kelas</a>
                @endif
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-126px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <li class="dropdown-title">Pilih Kelas</li>
                    @foreach ($kelas as $kel)
                        <li><a href="#" class="dropdown-item kelas-item" data-text="{{$kel->namaKelas()}}" data-id="{{$kel->id_kelas}}">{{$kel->namaKelas()}}</a></li>
                    @endforeach
                    <li><a href="#" class="dropdown-item kelas-item" data-text="Alumni" data-id="0">Alumni</a></li>
                </ul>
            </div>
            <form class="card-header-form" method="GET" action="{{url('rekap/per-siswa')}}">
                <div class="input-group">
                <input type="hidden" name="k" class="id_kelas" value="{{$k}}">
                <input type="text" name="q" class="form-control mr-2" value="{{$q}}" placeholder="Cari NISN atau Nama">
                <div class="input-group-btn">
                    <button type="submit"  class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                </div>
                </div>
            </form>
            </div>
            <div class="card-body">
            <div class="loader-line form-loader d-none mb-2"></div>
            
            <div class="table-responsive">
               {{-- moderation --}}
                <table class="table" style="color: black">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Terbayar</th>
                            <th>Kurang</th>
                            <th>Total Tanggungan</th>
                        </tr>
                    </thead>
                        @if(count($siswa) == 0)
                            <tr><td colspan="7" class="text-danger text-center">Data tidak di temukan</td></tr>
                        @else
                            @foreach($siswa as $s)
                            <tr>
                                <td rowspan="2" class="text-center" width="3%">{{$loop->iteration}}</td>
                                <td rowspan="2" >{{$s->nisn}}</td>
                                <td rowspan="2">{{$s->nama}}</td>
                                <td>Sekarang</td>
                                <td class="text-right">{{terbayar($terbayar,$s->id_siswa,1)[0]}}</td>
                                <td class="text-right">{{kurangAdm($administrasi,$s->id_siswa)[0]}}</td>
                                <td class="text-right">{{Helper::ribuan(kurangAdm($administrasi,$s->id_siswa)[1] + terbayar($terbayar,$s->id_siswa,1)[1])}}</td>
                            </tr>
                            <tr>
                                <td>Sebelumnya</td>
                                <td class="text-right">{{terbayar($terbayar,$s->id_siswa,2)[0]}}</td>
                                <td class="text-right">{{kurangTgg($tunggakan,$s->id_siswa)[0]}}</td>
                                <td class="text-right">{{Helper::ribuan(terbayar($terbayar,$s->id_siswa,2)[1] + kurangTgg($tunggakan,$s->id_siswa)[1])}}</td>
                            </tr>
                            @endforeach
                        @endif
                    
                </table>
                {{-- end moderation --}}
                <nav>
                @if(isset($_GET['q']))
                @php
                    $params = array('q' => $_GET['q']);
                @endphp
                {{ $siswa->appends($params)->links('vendor.paginate') }}
                @else
                {{ $siswa->links('vendor.paginate') }}
                @endif
                </nav>
            </div>
            </div>
        </div>
</section>

@endsection
@push('js')
<script>
    $(".kelas-item").click(function (e) { 
        e.preventDefault();
        $(".id_kelas").val($(this).data("id"));
        $(".filter-kelas").html("<i class='fas fa-filter'></i> Filter : "+$(this).data('text').toUpperCase());
    });
</script>
    
@endpush

