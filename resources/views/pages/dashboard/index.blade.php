@extends('app',['content'=>'dashboard'])
@push('style-library')
<link rel="stylesheet" href="{{asset('vendor')}}/jqvmap/jqvmap.min.css">
<link rel="stylesheet" href="{{asset('vendor')}}/summernote/summernote-bs4.css">
<link rel="stylesheet" href="{{asset('vendor')}}/owl-carousel/owl.carousel.min.css">
<link rel="stylesheet" href="{{asset('vendor')}}/owl-carousel/owl.theme.default.min.css">
@endpush
@section('content')
<?php use App\Traits\Helper; ?>
<section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-user-graduate"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Siswa</h4>
                  </div>
                  <div class="card-body">
                    {{$totalSiswa}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Pengeluaran</h4>
                  </div>
                  <div class="card-body">
                    Rp. {{Helper::ribuan($totalPengeluaran,2)}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Pemasukan</h4>
                  </div>
                  <div class="card-body">
                    Rp. {{Helper::ribuan($totalPemasukan,2)}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Statistics</h4>
                  
                </div>
                <div class="card-body">
                  <canvas id="myChart" height="225"></canvas>
            
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recent Activities</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="{{asset('/')}}assets/img/avatar/default.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right text-primary">Now</div>
                        <div class="media-title">Farhan A Mujib</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="{{asset('/')}}assets/img/avatar/avatar-2.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">12m</div>
                        <div class="media-title">Ujang Maman</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="{{asset('/')}}assets/img/avatar/avatar-3.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">17m</div>
                        <div class="media-title">Rizal Fakhri</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="{{asset('/')}}assets/img/avatar/avatar-4.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">21m</div>
                        <div class="media-title">Alfa Zulkarnain</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection
@push('js-library')
<script src="{{asset('vendor')}}/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="{{asset('vendor')}}/chart.js/Chart.min.js"></script>
<script src="{{asset('vendor')}}/owl-carousel/owl.carousel.min.js"></script>
<script src="{{asset('vendor')}}/summernote/summernote-bs4.js"></script>
<script src="{{asset('vendor')}}/chocolat/js/jquery.chocolat.min.js"></script>

<!-- Page Specific JS File -->
<script>
  
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    datasets: [{
      label: 'Pemasukan',
      data: <?= json_encode($dataStatistikPemasukan) ?>,
      borderWidth: 2,
      backgroundColor: 'rgba(63,82,227,.8)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
    },
    {
      label: 'Pengeluaran',
      data: <?= json_encode($dataStatistikPengeluaran) ?>,
      borderWidth: 2,
      backgroundColor: 'rgba(254,86,83,.7)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0 ,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 200000,
          callback: function(value, index, values) {
            return formatRupiah(value, 'Rp. ');
          }
        }
      }],
      xAxes: [{
        gridLines: {
          display: false,
          tickMarkLength: 15,
        }
      }]
    },
  } 
});
	function formatRupiah(angka, prefix){
			var number_string = angka.toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
</script>
@endpush