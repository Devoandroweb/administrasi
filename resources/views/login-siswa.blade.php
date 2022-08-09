@extends('app',['content'=>'login'])
@section('content-login')
<div class="bg-info w-100" style="height: 100vh">
  <div class="row justify-content-center mx-auto" style="height:100%">
    <div class="col col-md-5 p-5 p-lg-5">
      <div class="px-lg-5">
        <form action="{{url('/auth-siswa')}}" method="post"> 
          @csrf
          <div class="text-center">
            <img src="{{asset('assets/img/logo_sekolah.png')}}" class="mb-4" width="25%" alt=""> 
            <h3 class="text-white">Selamat datang di <br> SIA SMAI AL-HIKMAH</h3>
            <i class="text-dark">Login untuk mengetahui Keuangan Sekolah anda</i>
          </div>
          <hr> 
          @if(session('msg')) 
          <div class="alert alert-danger" role="alert">
            {{session('msg')}}
          </div> 
          @endif <div class="form-group">
            <label class="text-white">Nomor Induk Siswa (NIS)</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </div>
              </div>
              <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
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
          <button type="submit" class="btn btn-outline-white btn-block py-2">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection