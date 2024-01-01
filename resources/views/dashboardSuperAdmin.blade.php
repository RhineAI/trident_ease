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
        span .text-success {
            margin-left: 30px;
            vertical-align: middle;
            -webkit-transition: all 0.2s linear;
            transition: all 0.2s linear; 
        }
    </style>
@endpush
@section('contents')
<!-- Main content -->
<section class="content">
    <div class="row mb-3">
        {{-- Total Pegawai --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Level Free</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $free }} User</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-users fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Total Retur Penjualan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Level Plus</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $plus }} User</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plus fa-truck-ramp-box fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Total Retur Pembelian --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Level Pro</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pro }} User</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                            </div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-truck-ramp-box fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kas Masuk Perusahaan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Omset (Bulanan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ format_uang($omsetBulanan) }}</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-money-bill-1-wave fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pendapatan Bulanan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <input type="hidden" id="bulan1" value="{{ $bulan1 }}">
                        <input type="hidden" id="bulan2" value="{{ $bulan2 }}">
                        <input type="hidden" id="bulan3" value="{{ $bulan3 }}">
                        <input type="hidden" id="bulan4" value="{{ $bulan4 }}">
                        <input type="hidden" id="bulan5" value="{{ $bulan5 }}">
                        <input type="hidden" id="bulan6" value="{{ $bulan6 }}">
                        <input type="hidden" id="bulan7" value="{{ $bulan7 }}">
                        <input type="hidden" id="bulan8" value="{{ $bulan8 }}">
                        <input type="hidden" id="bulan9" value="{{ $bulan9 }}">
                        <input type="hidden" id="bulan10" value="{{ $bulan10 }}">
                        <input type="hidden" id="bulan11" value="{{ $bulan11 }}">
                        <input type="hidden" id="bulan12" value="{{ $bulan12 }}">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Omset (Tahunan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ format_uang($omsetTahunan) }}</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-money-bill-1-wave fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Keuntungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ format_uang($keuntungan) }}</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-coins fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
       
    </div>
    <!--Row-->

</section>
@endsection

@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');
    </script>
    <script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/js/chart-area-demo.js"></script> 
    <script>
        let valueDisplays = document.querySelectorAll('#count');
        let interval = 500;

        valueDisplays.forEach((valueDisplay) => {
            let startValue = 0;
            let endValue = parseInt(valueDisplay.getAttribute("data-val"));
            if(endValue == 0) {
                return false;
                // let duration = Math.floor(interval / 1);
            } else {
                let duration = Math.floor(interval / endValue);
                let counter = setInterval(function() {
                startValue += 1;
                valueDisplay.textContent = startValue;
                if(startValue == endValue) {
                    clearInterval(counter);
                    }
                }, duration);
            }
           
        });

        // Counter Number
        // console.log($('#count').val());
        // $('.count').each(function () {
        //     $(this).prop('Counter',0).animate({
        //         Counter: $(this).text()
        //     }, {
        //         duration: 300,
        //         easing: 'swing',
        //         step: function (now) {
        //             $(this).text(Math.ceil(now));
        //         }
        //     });
        // });
    </script>
  
@endpush