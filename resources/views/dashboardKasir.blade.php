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
    
@endpush
@section('contents')
    
<!-- Main content -->
<section class="content">
    <div class="row mb-3">
        <div class="card text-center ml-3 mr-3 w-100">
            <div class="card-header" style="background: #4195D5; color: white; font-size: 20px;">
              Selamat Datang {{ auth()->user()->nama }}
            </div>
            <div class="card-body text-center">
              <h5>Di Aplikasi ZiePOS</h5>
              <p class="card-text mb-3">Aplikasi penyedia layanan point of sale</p>

              <div>
                <strong>{{ $cPerusahaan->nama }}</strong>
                <br>
                <img src="{{ $cPerusahaan->logo }}" alt="{{ $cPerusahaan->nama }}" width="200">
                <p>{{ $cPerusahaan->slogan }}</p>
              </div>
            </div>
            <div class="card-footer text-muted">
              {{ $cPerusahaan->nama }} telah bergabung sejak {{ $cPerusahaan->created_at->diffForHumans() }}
            </div>
          </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');
    </script>
    {{-- <script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/js/chart-area-demo.js"></script>  --}}
  
@endpush