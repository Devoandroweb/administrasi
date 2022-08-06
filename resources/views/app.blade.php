<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>{{$title}} | Administrasi</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets')}}/img/favicon.ico">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/fontawesome-free/css/all.css"  >

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('vendor')}}/bootstrap/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/selectric/selectric.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/bootstrap/timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/bootstrap/tagsinput/bootstrap-tagsinput.css">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('vendor')}}/izitoast/css/iziToast.min.css">
  @stack('style-library')
  
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets')}}/css/style.css">
  <link rel="stylesheet" href="{{asset('assets')}}/css/custom.css">
  <link rel="stylesheet" href="{{asset('assets')}}/css/tooltip-dw.css">
  <link rel="stylesheet" href="{{asset('assets')}}/css/components.css">
  {{-- custom css --}}
  @stack('style')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      @if($content != 'login')
        @include('panels.navbar')
        @include('panels.sidebar')
        @include('panels.content')
        @include('panels.footer')
      @else
        @yield('content-login')
      @endif
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('assets')}}/js/stisla.js"></script>

  <!-- JS Libraies -->
  {{-- <script src="{{asset('vendor')}}/cleave-js/cleave.min.js"></script>
  <script src="{{asset('vendor')}}/cleave-js/addons/cleave-phone.us.js"></script> --}}
  <script src="{{asset('vendor')}}/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="{{asset('vendor')}}/bootstrap/daterangepicker/daterangepicker.js"></script>
  <script src="{{asset('vendor')}}/bootstrap/timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="{{asset('vendor')}}/bootstrap/tagsinput/bootstrap-tagsinput.min.js"></script>
  <script src="{{asset('vendor')}}/select2/js/select2.min.js"></script>
  <script src="{{asset('vendor')}}/selectric/jquery.selectric.min.js"></script>

  <!-- JS Libraies -->
  <script src="{{asset('vendor')}}/izitoast/js/iziToast.min.js"></script>
  @stack('js-library')

  <!-- Template JS File -->
  <script src="{{asset('assets')}}/js/scripts.js"></script>
  <script src="{{asset('assets')}}/js/custom.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <!-- Page Specific JS File -->
  {{-- <script src="{{asset('assets')}}/js/page/forms-advanced-forms.js"></script> --}}
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Pusher.logToConsole = true;
    //berjalan ketika pusher di akses
    var pusherClient = new Pusher('58eafcd4dda22b156f9f', {
        cluster: 'ap1'
    });
    var channel = pusherClient.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        console.log(data);
        if(data != null){
          $(".status-wa").removeClass('bg-danger');
          $(".status-wa").addClass('bg-success');
        }else{
          $(".status-wa").addClass('bg-danger');
          $(".status-wa").removeClass('bg-success');

        }
    });
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  {{-- cusom js --}}
  @stack('js')

</body>
</html>