<div class="main-sidebar sidebar-style-2">
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
              <li class="menu-header">Dashboard</li>
              @if(auth()->guard('siswa')->check())
              <li><a href="{{url('client/dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
              <li><a href="{{url('client/cetak-administrasi')}}" class="nav-link"><i class="fas fa-print"></i><span>Cetak Administrasi</span></a></li>
              @endif

              @if(auth()->guard('web')->check())
              <li><a href="{{url('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
              <li class="menu-header">Menu Utama</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-brain"></i> <span>Master</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{url('jenis-administrasi')}}">Jenis Administrasi</a></li>
                  <li><a class="nav-link" href="{{url('jurusan')}}">Data Jurusan</a></li>
                  <li><a class="nav-link" href="{{url('kelas')}}">Data Kelas</a></li>
                  <li><a class="nav-link" href="{{url('ajaran')}}">Data Ajaran</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-coins"></i> <span>Administrasi</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{url('administrasi-siswa')}}">Siswa</a></li>
                  <li><a class="nav-link" href="{{url('pendanaan')}}">Pendanaan</a></li>
                </ul>
              </li>
              <li><a class="nav-link" href="{{url('siswa')}}"><i class="fas fa-user-graduate"></i> <span>Siswa</span></a></li>
              <li><a class="nav-link" href="{{url('whatsapp')}}"><i class="fab fa-whatsapp"></i> <span>WA Gateway</span></a></li>
              <li><a class="nav-link" href="{{url('laporan')}}"><i class="fas fa-print"></i> <span>Report</span></a></li>
              <li><a class="nav-link" href="{{url('user')}}"><i class="fas fa-user-astronaut"></i> <span>User Management</span></a></li>
              @endif
          </ul>
          
        </aside>
      </div>