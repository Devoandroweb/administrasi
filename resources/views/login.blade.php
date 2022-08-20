@extends('app',['content'=>'login'])
@section('content-login')
@push('style')
<link rel="stylesheet" href="{{asset('assets/css/bg-animate.css')}}">
@endpush
{{-- css animate --}}
<div class="area" >
  <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
  </ul>
</div>
{{-- ----------------- --}}
<div class="context">
  <div class="w-100" style="height: 100vh">
    <div class="row justify-content-center mx-auto" style="height:100%">
      <div class="col col-md-5 p-5 px-lg-5 pb-lg-4">
        <div class="card shadow">
          <div class="card-body">
            <div class="p-lg-4">
              <form action="{{url('/auth')}}" method="post"> 
                @csrf
                <div class="text-center">
                  <img src="{{asset('assets/img/logo_sekolah.png')}}" class="mb-4" width="15%" alt=""> 
                  <p style="font-size: 15pt;font-weight:800" class="text-primary"><b class="text-success">S</b>istem <b class="text-success">I</b>nformasi <b class="text-success">A</b>dministrasi</p>
                  <p class="text-danger">Login with your Account</p>
                </div>
                <div class="waiting w-100 mb-4"><hr></div>
                @if(session('msg')) 
                <div class="alert alert-danger" role="alert">
                  {{session('msg')}}
                </div> 
                @endif
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-envelope"></i>
                      </div>
                    </div>
                    <input type="email" name="email" class="form-control" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                      </div>
                    </div>
                    <input type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator" required>
                  </div>
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <button type="submit" class="btn btn-danger btn-login btn-block py-2">Masuk</button>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div> 
</div>
@endsection
@push('js')
<script>
  $('.btn-login').click(function (e) { 
    // e.preventDefault();
    $(this).text("Tunggu Sebentar ...");
    $(this).attr('disabled','disabled');
    $(".waiting").html('<div class="loader-line app-loader"></div>');
  });
</script>
@endpush