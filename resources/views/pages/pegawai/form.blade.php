@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'nip';
$name[] = 'nama';
$name[] = 'jk';
$name[] = 'no_telp';
$name[] = 'alamat';
?>

<section class="section">
    <div class="section-header">
    <h1>{{$title}}</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('edit_pegawai') }}
    </div>
    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
            <small>Isikan dengan data yang sesuai</small>
            </div>
            <div class="card-body">
                @if(session('msg'))
                    <div class="alert alert-danger">{{session('msg')}}</div>
                @endif
                <form action="{{$url}}" method="post">
                       @csrf
                        {{$method != null ? $method : ''}}
                        <div class="row justify-content-center mb-4">
                            <div class="col">
                                <div class="image-live">
                                    <input type="file" class="d-none file-live" name="foto">
                                    <img src="{{asset('assets/img/avatar/avatar-5.png')}}"  style="width: 100px; height:100px" class="rounded-circle shadow mb-4 img-fluid" alt="" srcset="">
                                </div>
                                <div class="text-danger"><i>File Tidak Boleh Lebih besar dari 1Mb</i></div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">NIP</label>
                               @if(is_null($data))
                                    <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                               value="{{$newNip}}" name="{{$name[0]}}" autocomplete="off" readonly />
                               @else
                                    <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                               value="{{Helper::showData($data,$name[0])}}" name="{{$name[0]}}" autocomplete="off" />
                                @endif
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Nama</label>
                               <input type="text" class="form-control @error($name[1]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[1])}}" name="{{$name[1]}}" autocomplete="off" />
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Jenis Kelamin</label>
                               <select id="tipe" class="form-control @error($name[2]) is-invalid @enderror"
                                   name="{{$name[2]}}" autocomplete="off">
                                   <option value="" selected disabled> Pilih Jenis Kelamin</option>

                                   <option value="1" {{(old($name[2]) == 1) ? 'selected' : ''}}
                                       {{Helper::showDataSelected2($data,$name[2],1)}}>
                                       Laki - Laki
                                   </option>
                                   <option value="2" {{(old($name[2]) == 2) ? 'selected' : ''}}
                                       {{Helper::showDataSelected2($data,$name[2],2)}}>
                                       Perempuan
                                   </option>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">No Telepon</label>
                               <input type="text" class="form-control phone-number @error($name[3]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" autocomplete="off" />
                           </div>
                           {{-- <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Usia</label>
                               <input type="number" class="form-control @error($name[4]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[4])}}" name="{{$name[4]}}" autocomplete="off" />
                           </div> --}}
                           {{-- <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Jabatan</label>
                               <select id="tipe" class="form-control @error($name[5]) is-invalid @enderror"
                                   name="{{$name[5]}}" autocomplete="off" required>
                                   <option value="" selected disabled> Pilih Status Pasien</option>

                                   @foreach($departement as $key)
                                   <option value="<?= $key->{$name[2]} ?>"
                                       {{(old($name[2]) == $key->{$name[2]}) ? 'selected' : ''}}
                                       {{Helper::showDataSelected($data,$name[2],$key->{$name[2]})}}>
                                       {{$key->nama_departemen}}
                                   </option>
                                   @endforeach
                                   
                               </select>
                           </div> --}}
                           <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea type="text" class="form-control @error($name[4]) is-invalid @enderror" cols="5"
                                rows="6" style="height:100px" value="" name="{{$name[4]}}"
                                autocomplete="off">{{Helper::showData($data,$name[4])}}</textarea>
                            </div>
                        </div>
                       
                       <input type="submit" class="btn btn-success" value="Simpan" />
                       <a href="" onclick="history.back()" class="btn btn-default">Kembali</a>
                   </form>
            </div>
        </div>
</section>
@endsection
@push('js')
<script src="{{asset('vendor')}}/cleave.js/cleave.min.js"></script>
<script src="{{asset('vendor')}}/cleave.js/addons/cleave-phone.id.js"></script>
<script src="{{asset('assets')}}/js/image-live.js"></script>

<script>
    var cleavePN = new Cleave('.phone-number', {
        phone: true,
        phoneRegionCode: 'ID'
    });
    

</script>
@endpush