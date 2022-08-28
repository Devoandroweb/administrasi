@extends('app',['content'=>'user'])
@include('vendor.datatable')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'nisn';
$name[] = 'nama';
$name[] = 'tempat_lahir';
$name[] = 'tgl_lahir';
$name[] = 'jk';
$name[] = 'no_telp';
$name[] = 'alamat';
?>

<section class="section">
    <div class="section-header">
    <h1>{{$title}}</h1>
    {{-- breadcrumbs --}}
    {{ Breadcrumbs::render('edit_siswa') }}
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
                <form action="{{$url}}" method="post" enctype="multipart/form-data">
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
                               <label for="exampleInputEmail1">NISN (Nomor Induk Siswa Nasional)</label>
                               @if(is_null($data))
                                    <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                               value="{{$newNis}}" name="{{$name[0]}}" autocomplete="off"  />
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
                               <label for="exampleInputEmail1">Tempat Lahir</label>
                               <input type="text" class="form-control @error($name[2]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[2])}}" name="{{$name[2]}}" autocomplete="off" />
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Tanggal Lahir</label>
                               <input type="date" class="form-control @error($name[3]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" autocomplete="off" />
                           </div>

                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">Jenis Kelamin</label>
                               <select id="tipe" class="form-control @error($name[4]) is-invalid @enderror"
                                   name="{{$name[4]}}" autocomplete="off">
                                   <option value="" selected disabled> Pilih Jenis Kelamin</option>

                                   <option value="L" {{(old($name[4]) == "L") ? 'selected' : ''}}
                                       {{Helper::showDataSelected2($data,$name[4],"L")}}>
                                       Laki - Laki
                                   </option>
                                   <option value="P" {{(old($name[4]) == "P") ? 'selected' : ''}}
                                       {{Helper::showDataSelected2($data,$name[4],"P")}}>
                                       Perempuan
                                   </option>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1">No Telepon</label>
                               <input type="text" class="form-control phone-number @error($name[5]) is-invalid @enderror"
                                   value="{{Helper::showData($data,$name[5])}}" name="{{$name[5]}}" autocomplete="off" />
                           </div>
                          
                         
                           <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea type="text" class="form-control @error($name[6]) is-invalid @enderror" cols="5"
                                rows="6" style="height:100px" value="" name="{{$name[6]}}"
                                autocomplete="off">{{Helper::showData($data,$name[6])}}</textarea>
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