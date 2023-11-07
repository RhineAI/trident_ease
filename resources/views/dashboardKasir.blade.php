@extends('templates.layout')

@section('title')
    <title>Dashboard | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Dashboard
@endsection

@section('breadcrumb')
@parent
    Dashboard
@endsection

@push('styles')
    <style>
       
      .card.panels-card .hour {
        font-size: 0.8rem;
        margin-top: 0.3rem;
      }

      a {
        animation: ease-in;
      }

      a:hover {
        text-decoration: none;
        transform: scale(1.05)
      }

      h6 {
        text-align: center;
      }

      .cover-card {
        box-shadow: 5px 10px 8px ;
      }

      .wrimagecard {
          margin-top: 0;
          margin-bottom: 1.5rem;
          text-align: left;
          position: relative;
          background: #fff;
          box-shadow: 12px 15px 20px 0px rgba(46, 61, 73, 0.15);
          border-radius: 4px;
          transition: all 0.3s ease;
      }

      .wrimagecard .fa {
          position: relative;
          font-size: 70px;
      }

      .wrimagecard-topimage_header {
          padding: 20px;
      }

      a.wrimagecard:hover,
      .wrimagecard-topimage:hover
      .card-info {
          box-shadow: 2px 4px 8px 0px rgba(46, 61, 73, 0.2);
      }

      .wrimagecard-topimage a {
          width: 100%;
          height: 100%;
          display: block;
      }

      .wrimagecard-topimage_title {
          padding: 20px 24px;
          height: 80px;
          padding-bottom: 0.75rem;
          position: relative;
      }

      .wrimagecard-topimage a .card-info{
          border-bottom: none;
          text-decoration: none;
          color: #525c65;
          transition: color 0.3s ease;
      }

      --fa-animation-delay{
        animation-delay: 1.5s;
      }

      
    </style>
@endpush
@section('contents')
@php
    $grade = auth()->user()->perusahaan->grade;
@endphp
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ route('kasir.transaksi-penjualan.index') }}">
                    <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                        <center><i class="fa-solid fa-cart-shopping fa-4x fa-fade" style="color:#BB7824;"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title">
                        <h4>Transaksi Baru
                            <div class="pull-right badge"></div>
                        </h4>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-4 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                @if ($grade >= 2)
                    <a href="{{ route('kasir.pelanggan.index') }}">
                @else 
                    <a href="#" onclick="featureNotAvailable()">    
                @endif
                    <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                        <center><i class="fa-solid fa-user fa-4x fa-fade" style="color:#16A085"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title">
                        <h4>Tambah Pelanggan
                            <div class="pull-right badge" id="WrControls"></div>
                        </h4>
                    </div>
                </a>
            </div>
        </div>
       
        <div class="col-md-4 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                @if ($grade >= 2)
                    <a href="{{ route('kasir.retur-penjualan.index') }}">
                @else 
                    <a href="#" onclick="featureNotAvailable()">    
                @endif
                    <div class="wrimagecard-topimage_header" style="background-color:  rgba(51, 105, 232, 0.1)">
                        <center><i class="fa-solid fa-rotate-left fa-4x fa-fade" style="color:#3369e8"> </i></center>
                    </div>
                    <div class="wrimagecard-topimage_title">
                        <h4>Retur Barang
                            <div class="pull-right badge" id="WrGridSystem"></div>
                        </h4>
                    </div>

                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                        <div class="d-flex flex-row">
                            <div class="align-self-center">
                                <i class="fas fa-pencil-alt text-info fa-3x me-4 mx-3"></i>
                            </div>
                            <div>
                                <h4>Total Transaksi</h4>
                                <p class="mb-0">Bulan ini</p>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <h2 class="h1 mb-0">{{ $transaksi }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                        <div class="d-flex flex-row">
                            <div class="align-self-center">
                                <i class="fas fa-users text-secondary fa-3x me-4 mx-3"></i>
                            </div>
                            <div>
                                <h4>Total Pelanggan</h4>
                                <p class="mb-0">&nbsp;</p>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <h2 class="h1 mb-0">{{ $pelanggan }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                        <div class="d-flex flex-row">
                            <div class="align-self-center">
                                <h2 class="h1 mb-0 me-4 mx-3">Rp. {{ format_uang($total_harga) }}</h2>
                            </div>
                            <div>
                                <h4>Total Penjualan</h4>
                                <p class="mb-0">Bulan Ini</p>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-cash-register text-success fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                        <div class="d-flex flex-row">
                            <div class="align-self-center">
                                <h2 class="h1 mb-0 me-4 mx-3">Rp. {{ $total_retur }}</h2>
                            </div>
                            <div>
                                <h4>Total Retur</h4>
                                <p class="mb-0">Bulan Ini</p>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-wallet text-danger fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
{{-- </div> --}}
{{-- <section class="content">
  
    <div class="row mb-3">
        <div class="card text-center ml-3 mr-3 w-100">
            <div class="card-header" style="background: #4195D5; color: white; font-size: 20px;">
              Selamat Datang {{ auth()->user()->nama }}
            </div>
            <div class="card-body text-center">
              <div>
                Anda saat ini login sebagai pegawai perusahaan
                <br>
                <strong>{{ $cPerusahaan->nama }}</strong>
                <br>
                <img src="{{ $cPerusahaan->logo }}" alt="{{ $cPerusahaan->nama }}" width="200">
              </div>
            </div>
            <br>
            <p class="slogan">{{ $cPerusahaan->slogan }}</p>
            <div class="card-footer text-muted">
              {{ $cPerusahaan->nama }} telah bergabung sejak {{ $cPerusahaan->created_at->diffForHumans() }}
            </div>
          </div>
    </div>
   
</section> --}}
@endsection

@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');

        const card = document.querySelector('.map-card');
        const cardBody = card.querySelector('.card-body')

        card.addEventListener('click', () => {
          cardBody.classList.toggle('closed')
        })

        function featureNotAvailable() {
            Swal.fire({
                title: "Fitur Tidak Dapat Diakses",
                text: "Silahkan untuk tingkatkan level akses anda terlebih dahulu!",
                icon : "warning",
                showDenyButton: true,
                confirmButtonText: "Upgrade!",
                denyButtonText: "Ok",
                showClass: {
                    popup: `
                        animate__animated
                        animate__fadeInUp
                        animate__faster
                    `
                },
                hideClass: {
                    popup: `
                        animate__animated
                        animate__fadeOutDown
                        animate__faster
                    `
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href("https://wa.wizard.id/8fd751");
                } 
            });
        }
    </script>
    {{-- <script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/js/chart-area-demo.js"></script>  --}}
  
@endpush