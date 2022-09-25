@php
    function menuActive($url){
      if(url()->current() == $url){
        return 'active';
      }
    }
    function menuActiveDropdown($index){
      $url[] = [
          url('jenis-administrasi'),
          url('jurusan'),
          url('kelas'),
          url('ajaran'),
          url('siswa')
      ];
      $url[] = [
          url('administrasi-siswa'),
          url('pendanaan')
      ];
      $url[] = [
          url('rekap/per-kelas'),
          url('rekap/per-siswa')
      ];
      if(in_array(url()->current(),$url[$index])){
        return 'active';
      }
    }
@endphp
<div class="main-sidebar sidebar-style-2" style="padding-bottom: 2rem;">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{url('dashboard')}}">
        <img src="{{asset('assets/img/logo_sekolah.png')}}" class="mr-1 mt-3" width="15%" alt=""> <br> 
        SIA SMAI AL-HIKMAH
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <img src="{{asset('assets/img/logo_sekolah.png')}}" class="mr-1 mt-3" width="50%" alt=""> <br>
    </div>
    <hr>
    <ul class="sidebar-menu">
        {{-- <li class="menu-header">Dashboard</li> --}}
          @if(auth()->guard('siswa')->check())
          <li class="{{menuActive(url('client/dashboard'))}}"><a href="{{url('client/dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
          <li class="{{menuActive(url('client/profile'))}}"><a href="{{url('client/profile')}}" class="nav-link"><i class="fas fa-user"></i><span>Profile</span></a></li>
          <li class="{{menuActive(url('client/cetak-administrasi'))}}"><a href="{{url('client/cetak-administrasi')}}" class="nav-link"><i class="fas fa-print"></i><span>Cetak Administrasi</span></a></li>
          @endif

          @if(auth()->guard('web')->check())
          <li class="{{menuActive(url('dashboard'))}}"><a href="{{url('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
          @if(auth()->guard('web')->user()->role == 3)
          <li class="{{menuActive(url('siswa'))}}"><a href="{{url('siswa')}}" class="nav-link"><i class="fas fa-user-graduate"></i><span>Siswa</span></a></li>
          @else
          <li class="menu-header">Menu Utama</li>
          <li class="nav-item dropdown {{menuActiveDropdown(0)}}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-brain"></i> <span>Master</span></a>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{url('jenis-administrasi')}}">Jenis Biaya</a></li>
              <li><a class="nav-link" href="{{url('jurusan')}}">Data Jurusan</a></li>
              <li><a class="nav-link" href="{{url('kelas')}}">Data Kelas</a></li>
              <li><a class="nav-link" href="{{url('ajaran')}}">Data Ajaran</a></li>
              <li><a class="nav-link" href="{{url('siswa')}}">Data Siswa</a></li>
            </ul>
          </li>
          @endif
          <li class="nav-item dropdown {{menuActiveDropdown(1)}}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-coins"></i> <span>Biaya</span></a>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{url('administrasi-siswa')}}">Siswa</a></li>
              <li><a class="nav-link" href="{{url('pendanaan')}}">Pendanaan</a></li>
            </ul>
          </li>
          <li class="menu-header">Laporan</li>
          
          <li class="{{menuActive(url('rekap/per-siswa'))}}"><a class="nav-link" href="{{url('rekap/per-siswa')}}"><i class="fas fa-book"></i> <span>Rekap</span></a></li>
          <li class="{{menuActive(url('htransaksi'))}}"><a class="nav-link" href="{{url('htransaksi')}}"><i class="fas fa-clock"></i> <span>Riwayat Transaksi</span></a></li>
          <li class="{{menuActive(url('laporan'))}}"><a class="nav-link" href="{{url('laporan')}}"><i class="fas fa-print"></i> <span>Report</span></a></li>

          @if(auth()->guard('web')->user()->role != 3)
          <li class="menu-header">Lainnya</li>
          <li class="{{menuActive(url('whatsapp'))}}"><a class="nav-link" href="{{url('whatsapp')}}"><i class="fab fa-whatsapp"></i> <span>WA Gateway</span></a></li>
          <li class="{{menuActive(url('user'))}}"><a class="nav-link" href="{{url('user')}}"><i class="fas fa-user-astronaut"></i> <span>User Management</span></a></li>
          @endif
        @endif
    </ul>
    
  </aside>
</div>