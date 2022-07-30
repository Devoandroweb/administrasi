@extends('app',['content'=>'login'])
@section('content-login')
<div class="bg-white w-100" style="height: 100vh">
  <div class="row justify-content-center mx-auto" style="height:100%">
    <div class="col-0 col-md-6 text-center border-right d-flex align-items-center">
      <img src="{{asset('assets/img/hr.gif')}}" class="w-50 m-auto d-none d-md-block" alt="">
    </div>
    <div class="col p-5 p-lg-5">
      <div class="p-lg-5">
        <form action="{{url('/auth')}}" method="post"> @csrf <h3 class="text-primary">Welcome to <br> Sistem Informasi Administrasi</h3>
          <p class="text-primary">Login with your Account</p>
          <hr> 
          @if(session('msg')) 
          <div class="alert alert-danger" role="alert">
            {{session('msg')}}
          </div> 
          @endif <div class="form-group">
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
          <button type="submit" class="btn btn-danger btn-block py-2">Go</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection