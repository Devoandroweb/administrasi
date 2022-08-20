@extends('app',['content'=>'login'])
@section('content-login')
@push('style')
<link rel="stylesheet" href="{{asset('assets/css/bg-animate.css')}}">
@endpush
<div class="w-100" style="height: 100vh">
  <div class="bg"></div>
  <div class="bg bg2"></div>
  <div class="bg bg3"></div>
  <div class="content w-100">
    <div class="row justify-content-center mx-auto" style="height:80%">
      <div class="col col-md-4">
        <div class="">
          <form action="{{url('/auth-siswa')}}" method="post"> 
            @csrf
            <div class="text-center">
              <img src="{{asset('assets/img/logo_sekolah.png')}}" class="mb-4" width="25%" alt=""> 
              <h3 class="text-white">Selamat datang di <br> SIA SMAI AL-HIKMAH</h3>
              <i class="text-dark">Login untuk mengetahui Keuangan Sekolah anda</i>
            </div>
            <div class="waiting w-100 mb-4 mt-3"><hr></div>
            @if(session('msg')) 
            <div class="alert alert-danger" role="alert">
              {{session('msg')}}
            </div> 
            @endif <div class="form-group">
              <label class="text-white">Nomor Induk Siswa Nasional (NISN)</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-envelope"></i>
                  </div>
                </div>
                <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" required>
              </div>
            </div>
            <div class="form-group">
              <label class="text-white">Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <input type="password" name="password" class="form-control pwstrength" placeholder="Masukkan Password" data-indicator="pwindicator" required>
              </div>
              <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
              </div>
            </div>
            <button type="submit" class="btn btn-outline-white btn-login btn-block py-2">Masuk</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
  $('body').addClass('bg-info');
  $('.btn-login').click(function (e) { 
    // e.preventDefault();
    $(this).text("Tunggu Sebentar ...");
    $(this).attr('disabled','disabled');
    $(".waiting").html('<div class="loader-line app-loader"></div>');
  });
</script>
@endpush