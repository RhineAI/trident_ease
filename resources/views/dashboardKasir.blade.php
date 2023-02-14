@extends('templates.layout')

@section('title')
    <title>Dashboard | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Dashboard
@endsection

@section('breadcrumb')
@parent
    Pemasok
@endsection

@push('styles')
    <style>
       
      .card.panels-card .hour {
        font-size: 0.8rem;
        margin-top: 0.3rem;
      }
      
    </style>
@endpush
@section('contents')
    
<!-- Main content -->
<div class="container-fluid">
    <section>
      {{-- <div class="card panels-card"> --}}
          {{-- <div class="rounded-top" style="background-color: #4195D5;">
              <ul class="list-inline float-end my-0 py-1 pe-3">
                  <li class="list-inline-item">
                      <i class="fab fa-facebook" aria-hidden="true"></i>
                  </li>
                  <li class="list-inline-item">
                      <i class="fab fa-twitter" aria-hidden="true"></i>
                  </li>
                  <li class="list-inline-item">
                      <i class="fab fa-instagram" aria-hidden="true"></i>
                  </li>
              </ul>
          </div> --}}
          {{-- <nav class="navbar navbar-expand-lg navbar-dark d-flex justify-content-between z-depth-1-bottom px-3"
              style="background-color: #fafafa;">
          </nav> --}}
          <div class="card-body rounded-bottom text-dark">
              <div class="row">
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.transaksi-penjualan.index') }}" style="color:white;">
                        <div class="card" style="background-color: #4195D5;">
                            <div class="card-body pb-0">
                                <i class="fas fa-solid fa-cart-plus fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">15&deg;</p>
                                    <p class="mb-0 hour">12:15 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Tambah Transaksi Baru</h6>
                                {{-- <p class="mb-0">Cloudy</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.pelanggan2') }}" style="color: #4195D5;">
                        <div class="card" style="background-color: white">
                            <div class="card-body pb-0">
                                <i class="fas fa-user fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">23&deg;</p>
                                    <p class="mb-0 hour">3:25 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Tambah Pelanggan Baru</h6>
                                {{-- <p class="mb-0">Sunny</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.retur-penjualan.index') }}" style="color: white;">
                        <div class="card" style="background-color: #4195D5;">
                            <div class="card-body pb-0">
                                <i class="fas fa-rotate-left fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">23&deg;</p>
                                    <p class="mb-0 hour">3:25 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Tambah Retur Baru</h6>
                                {{-- <p class="mb-0">Sunny</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
              </div>

              <div class="row">
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.list-transaksi.index') }}" style="color:white;">
                        <div class="card" style="background-color: #4195D5;">
                            <div class="card-body pb-0">
                                <i class="fas fa-solid fa-cart-plus fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">15&deg;</p>
                                    <p class="mb-0 hour">12:15 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Data Transaksi</h6>
                                {{-- <p class="mb-0">Cloudy</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.pelanggan.index') }}" style="color: #4195D5;">
                        <div class="card" style="background-color: white">
                            <div class="card-body pb-0">
                                <i class="fas fa-user fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">23&deg;</p>
                                    <p class="mb-0 hour">3:25 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Data Pelanggan</h6>
                                {{-- <p class="mb-0">Sunny</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 p-1">
                    <a href="{{ route('kasir.list-retur-penjualan.index') }}" style="color: white;">
                        <div class="card" style="background-color: #4195D5;">
                            <div class="card-body pb-0">
                                <i class="fas fa-rotate-left fa-3x pb-4"></i>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-0 h5">23&deg;</p>
                                    <p class="mb-0 hour">3:25 PM</p>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="card-body pt-0">
                                <h6 class="font-weight-bold mb-1">Data Retur</h6>
                                {{-- <p class="mb-0">Sunny</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
              </div>
          </div>
      {{-- </div> --}}

        {{-- <div class="row">
            <div class="col-12 mt-3 mb-1">
                <h5 class="text-uppercase">Statistics With Subtitle</h5>
                <p>Statistics on minimal cards with Title &amp; Sub Title.</p>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between p-md-1">
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <i class="fas fa-pencil-alt text-info fa-3x me-4"></i>
                                </div>
                                <div>
                                    <h4>Total Posts</h4>
                                    <p class="mb-0">Monthly blog posts</p>
                                </div>
                            </div>
                            <div class="align-self-center">
                                <h2 class="h1 mb-0">18,000</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between p-md-1">
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <i class="far fa-comment-alt text-warning fa-3x me-4"></i>
                                </div>
                                <div>
                                    <h4>Total Comments</h4>
                                    <p class="mb-0">Monthly blog posts</p>
                                </div>
                            </div>
                            <div class="align-self-center">
                                <h2 class="h1 mb-0">84,695</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between p-md-1">
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <h2 class="h1 mb-0 me-4">$76,456.00</h2>
                                </div>
                                <div>
                                    <h4>Total Sales</h4>
                                    <p class="mb-0">Monthly Sales Amount</p>
                                </div>
                            </div>
                            <div class="align-self-center">
                                <i class="far fa-heart text-danger fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between p-md-1">
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <h2 class="h1 mb-0 me-4">$36,000.00</h2>
                                </div>
                                <div>
                                    <h4>Total Cost</h4>
                                    <p class="mb-0">Monthly Cost</p>
                                </div>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-wallet text-success fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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
    </script>
    {{-- <script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/js/chart-area-demo.js"></script>  --}}
  
@endpush