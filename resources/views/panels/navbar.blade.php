<?php use Illuminate\Support\Facades\Http; ?>
<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li class="">

            <a href="javascript:;" class="nav-link nav-link-lg d-md-flex align-items-center font-weight-bold">
              <span class="d-none d-md-block mr-1">Tahun Akademik : </span>
              <span class="d-md-none">TA : </span>
              
                @php
                    echo Session::get('tahun_awal')." - ".Session::get('tahun_akhir');
                @endphp
              
            </a>
          </li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          
          @if(auth()->guard('web')->check())
          @if(auth()->guard('web')->user()->role != 3)
          <li class="nav-item active">
            <a href="{{url('pembayaran')}}" class="nav-link nav-link-lg d-flex align-items-center">
              <span class="btn btn-warning rounded-pill">
                <i class="fas fa-hand-holding-usd" style="font-size: 13px"></i>  
                   Pembayaran Siswa
                </span>
            </a>
          </li>
          
          <li class="nav-item active">
            <a href="{{url('whatsapp')}}" class="nav-link nav-link-lg d-flex align-items-center">
              <?php 
                
                $res = null;
                try {
                  $res = Http::get("http://localhost:8989/check-auth")->throw()->json();
                } catch (\Throwable $th) {
                  $activeWa = 'bg-danger';
                }
                if($res != null){
                    $activeWa = 'bg-success';
                }else{
                    $activeWa = 'bg-danger';
                }
              ?>
              <span class="dot {{$activeWa}} mr-2 status-wa"></span> Whatsapp Gateway
            </a>
          </li>
          @endif
          @endif
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('assets')}}/img/avatar/default.png" class="rounded-circle mr-1">
            @if(Auth::guard('web')->check())
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div></a>
            @endif
            @if(Auth::guard('siswa')->check())
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::guard('siswa')->user()->nama}}</div></a>
            @endif
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 5 min ago</div>
              @if(auth()->guard('web')->check())
              
              <a href="{{url('reset-administrasi')}}" id="reset_adm" class="dropdown-item has-icon">
                <i class="fas fa-redo"></i> Calculate Administrasi
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
              @endif

              @if(auth()->guard('siswa')->check())
              <a href="{{route('logout-siswa')}}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
              @endif
            </div>
          </li>
        </ul>
      </nav>